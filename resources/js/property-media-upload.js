const CATEGORY_CONFIG = {
    main_image: {
        hiddenName: 'main_image_key',
        maxBytes: 10 * 1024 * 1024,
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    },
    gallery_image: {
        hiddenName: 'gallery_image_keys[]',
        maxBytes: 10 * 1024 * 1024,
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    },
    property_video: {
        hiddenName: 'property_video_keys[]',
        maxBytes: 500 * 1024 * 1024,
        mimeTypes: ['video/mp4', 'video/webm', 'video/quicktime'],
    },
};

function integerValue(value) {
    const parsed = Number.parseInt(value ?? '0', 10);

    return Number.isNaN(parsed) ? 0 : parsed;
}

function createStatusElement(form) {
    const existing = form.querySelector('[data-media-upload-status]');

    if (existing) {
        return existing;
    }

    const wrapper = document.createElement('div');
    wrapper.dataset.mediaUploadStatus = '';
    wrapper.className = 'mt-6 hidden rounded-2xl border border-slate-200 bg-slate-50 p-4';
    wrapper.innerHTML = `
        <p data-media-upload-message class="font-semibold text-[#0A2E5D]"></p>
        <div class="mt-3 h-3 overflow-hidden rounded-full bg-slate-200">
            <div
                data-media-upload-progress
                class="h-full w-0 rounded-full bg-[#C89B3C] transition-all"
            ></div>
        </div>
    `;

    const submitButton = form.querySelector(
        'button[type="submit"], button:not([type])'
    );

    if (submitButton) {
        submitButton.before(wrapper);
    } else {
        form.append(wrapper);
    }

    return wrapper;
}

function setStatus(status, message, percentage, isError = false) {
    status.classList.remove('hidden');

    const messageElement = status.querySelector(
        '[data-media-upload-message]'
    );
    const progressElement = status.querySelector(
        '[data-media-upload-progress]'
    );

    messageElement.textContent = message;
    messageElement.classList.toggle('text-red-700', isError);
    messageElement.classList.toggle('text-[#0A2E5D]', !isError);
    progressElement.style.width = `${Math.max(0, Math.min(100, percentage))}%`;
}

function csrfToken(form) {
    return form.querySelector('input[name="_token"]')?.value
        ?? document.querySelector('meta[name="csrf-token"]')?.content
        ?? '';
}

function selectedFiles(form) {
    const selections = [];

    form.querySelectorAll('input[type="file"][data-media-category]')
        .forEach((input) => {
            Array.from(input.files ?? []).forEach((file) => {
                selections.push({
                    input,
                    file,
                    category: input.dataset.mediaCategory,
                });
            });
        });

    return selections;
}

function validateSelection(form, selections) {
    for (const selection of selections) {
        const config = CATEGORY_CONFIG[selection.category];

        if (!config) {
            throw new Error('Catégorie de média inconnue.');
        }

        if (!config.mimeTypes.includes(selection.file.type)) {
            throw new Error(
                `Le format du fichier "${selection.file.name}" n’est pas autorisé.`
            );
        }

        if (selection.file.size > config.maxBytes) {
            const maximumMegabytes = Math.ceil(
                config.maxBytes / 1024 / 1024
            );

            throw new Error(
                `Le fichier "${selection.file.name}" dépasse ${maximumMegabytes} Mo.`
            );
        }
    }

    const existingMain = integerValue(
        form.dataset.existingMainImage
    );
    const existingGallery = integerValue(
        form.dataset.existingGalleryCount
    );
    const existingVideos = integerValue(
        form.dataset.existingVideoCount
    );

    const pendingMain = form.querySelector(
        'input[name="main_image_key"]'
    ) ? 1 : 0;

    const pendingGallery = form.querySelectorAll(
        'input[name="gallery_image_keys[]"]'
    ).length;

    const pendingVideos = form.querySelectorAll(
        'input[name="property_video_keys[]"]'
    ).length;

    const selectedMain = selections.some(
        (selection) => selection.category === 'main_image'
    ) ? 1 : 0;

    const selectedGallery = selections.filter(
        (selection) => selection.category === 'gallery_image'
    ).length;

    const selectedVideos = selections.filter(
        (selection) => selection.category === 'property_video'
    ).length;

    const effectiveMain = selectedMain
        ? 1
        : Math.max(existingMain, pendingMain);

    const totalImages = effectiveMain
        + existingGallery
        + pendingGallery
        + selectedGallery;

    if (totalImages > 4) {
        throw new Error(
            'Un bien ne peut pas contenir plus de 4 images au total.'
        );
    }

    if (
        existingVideos
        + pendingVideos
        + selectedVideos
        > 2
    ) {
        throw new Error(
            'Un bien ne peut pas contenir plus de 2 vidéos.'
        );
    }
}

async function requestPresignedUpload(form, selection) {
    const response = await fetch(form.dataset.presignUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken(form),
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
            category: selection.category,
            filename: selection.file.name,
            content_type: selection.file.type,
            size: selection.file.size,
        }),
    });

    const payload = await response.json().catch(() => ({}));

    if (!response.ok) {
        const firstValidationError = payload.errors
            ? Object.values(payload.errors).flat()[0]
            : null;

        throw new Error(
            firstValidationError
            ?? payload.message
            ?? 'Impossible de préparer l\'envoi du média.'
        );
    }

    return payload;
}

function uploadFile(upload, file, onProgress) {
    return new Promise((resolve, reject) => {
        const request = new XMLHttpRequest();
        request.open('PUT', upload.url, true);

        const headers = upload.headers ?? {};
        let hasContentType = false;

        Object.entries(headers).forEach(([name, value]) => {
            const lowerName = name.toLowerCase();

            if (
                lowerName === 'host'
                || lowerName === 'content-length'
            ) {
                return;
            }

            if (lowerName === 'content-type') {
                hasContentType = true;
            }

            request.setRequestHeader(name, String(value));
        });

        if (!hasContentType) {
            request.setRequestHeader('Content-Type', file.type);
        }

        request.upload.addEventListener('progress', (event) => {
            if (event.lengthComputable) {
                onProgress(
                    Math.round((event.loaded / event.total) * 100)
                );
            }
        });

        request.addEventListener('load', () => {
            if (request.status >= 200 && request.status < 300) {
                resolve();
                return;
            }

            reject(
                new Error(
                    `Cloudflare R2 a refusé l’envoi (${request.status}).`
                )
            );
        });

        request.addEventListener('error', () => {
            reject(
                new Error(
                    'Erreur réseau pendant l’envoi vers Cloudflare R2.'
                )
            );
        });

        request.addEventListener('abort', () => {
            reject(new Error('Envoi du média annulé.'));
        });

        request.send(file);
    });
}

function appendUploadedKey(form, category, key) {
    const config = CATEGORY_CONFIG[category];

    if (category === 'main_image') {
        form.querySelectorAll('input[name="main_image_key"]')
            .forEach((input) => input.remove());
    }

    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = config.hiddenName;
    hiddenInput.value = key;
    hiddenInput.dataset.uploadedMediaKey = category;

    form.append(hiddenInput);
}

function disableFileInputs(form) {
    form.querySelectorAll('input[type="file"][data-media-category]')
        .forEach((input) => {
            input.disabled = true;
        });
}

function setSubmitDisabled(form, disabled) {
    form.querySelectorAll(
        'button[type="submit"], button:not([type])'
    ).forEach((button) => {
        button.disabled = disabled;
        button.classList.toggle('opacity-60', disabled);
        button.classList.toggle('cursor-not-allowed', disabled);
    });
}

function initializeMediaForm(form) {
    const status = createStatusElement(form);

    form.addEventListener('submit', async (event) => {
        if (form.dataset.mediaReady === '1') {
            return;
        }

        const selections = selectedFiles(form);

        if (selections.length === 0) {
            return;
        }

        event.preventDefault();

        try {
            validateSelection(form, selections);
            setSubmitDisabled(form, true);

            for (let index = 0; index < selections.length; index++) {
                const selection = selections[index];
                const currentNumber = index + 1;

                setStatus(
                    status,
                    `Préparation du média ${currentNumber}/${selections.length} : ${selection.file.name}`,
                    0
                );

                const upload = await requestPresignedUpload(
                    form,
                    selection
                );

                await uploadFile(
                    upload,
                    selection.file,
                    (filePercentage) => {
                        const overallPercentage = Math.round(
                            (
                                index
                                + (filePercentage / 100)
                            )
                            / selections.length
                            * 100
                        );

                        setStatus(
                            status,
                            `Envoi du média ${currentNumber}/${selections.length} : ${selection.file.name}`,
                            overallPercentage
                        );
                    }
                );

                appendUploadedKey(
                    form,
                    selection.category,
                    upload.key
                );
            }

            setStatus(
                status,
                'Tous les médias ont été envoyés. Enregistrement du bien...',
                100
            );

            disableFileInputs(form);
            form.dataset.mediaReady = '1';
            form.requestSubmit();
        } catch (error) {
            console.error(error);
            setSubmitDisabled(form, false);
            setStatus(
                status,
                error instanceof Error
                    ? error.message
                    : '`Une erreur est survenue pendant l’envoi.`',
                0,
                true
            );
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-media-upload-form]')
        .forEach(initializeMediaForm);
});
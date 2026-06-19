

<?php $__env->startSection('content'); ?>

<section class="min-h-screen bg-[#F8F9FB] py-12 px-6">

    <div class="max-w-5xl mx-auto">

        <div class="flex items-center justify-between mb-10">

            <div>
                <p class="text-[#C89B3C] font-bold uppercase tracking-[0.3em]">
                    Administration
                </p>

                <h1 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    Paramètres du site
                </h1>
            </div>

            <a
                href="<?php echo e(route('admin.dashboard')); ?>"
                class="rounded-full border border-[#0A2E5D] px-6 py-3 font-bold text-[#0A2E5D] hover:bg-[#0A2E5D] hover:text-white transition"
            >
                Retour Dashboard
            </a>

        </div>

        <?php if(session('success')): ?>

            <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 p-5 text-green-700">
                <?php echo e(session('success')); ?>

            </div>

        <?php endif; ?>

        <?php if($errors->any()): ?>

            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-5 text-red-700">

                <p class="font-bold mb-3">
                    Veuillez corriger les erreurs suivantes :
                </p>

                <ul class="list-disc pl-5 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

            </div>

        <?php endif; ?>

        <div class="bg-white rounded-3xl shadow-xl p-10">

            <form
                action="<?php echo e(route('admin.site-settings.update')); ?>"
                method="POST"
                enctype="multipart/form-data"
            >

                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                

                <h2 class="text-2xl font-black text-[#0A2E5D] mb-6">
                    Branding
                </h2>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-semibold">
                            Nom du site
                        </label>

                        <input
                            type="text"
                            name="site_name"
                            value="<?php echo e(old('site_name', $settings->site_name)); ?>"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Logo
                        </label>

                        <input
                            type="file"
                            name="logo"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >

                        <?php if($settings->logo): ?>

                            <img
                                src="<?php echo e(asset('images/settings/' . $settings->logo)); ?>"
                                class="h-20 mt-4 rounded-xl"
                                alt=""
                            >

                        <?php endif; ?>
                    </div>

                </div>

                

                <h2 class="text-2xl font-black text-[#0A2E5D] mt-12 mb-6">
                    Coordonnées
                </h2>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-semibold">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="<?php echo e(old('email', $settings->email)); ?>"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            WhatsApp
                        </label>

                        <input
                            type="text"
                            name="whatsapp"
                            value="<?php echo e(old('whatsapp', $settings->whatsapp)); ?>"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Téléphone 1
                        </label>

                        <input
                            type="text"
                            name="phone_1"
                            value="<?php echo e(old('phone_1', $settings->phone_1)); ?>"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Téléphone 2
                        </label>

                        <input
                            type="text"
                            name="phone_2"
                            value="<?php echo e(old('phone_2', $settings->phone_2)); ?>"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >
                    </div>

                </div>

                <div class="mt-6">
                    <label class="block mb-2 font-semibold">
                        Adresse
                    </label>

                    <textarea
                        name="address"
                        rows="3"
                        class="w-full border border-slate-200 rounded-xl p-4"
                    ><?php echo e(old('address', $settings->address)); ?></textarea>
                </div>

                

                <h2 class="text-2xl font-black text-[#0A2E5D] mt-12 mb-6">
                    Réseaux sociaux
                </h2>

                <div class="grid md:grid-cols-2 gap-6">

                    <input
                        type="url"
                        name="facebook"
                        value="<?php echo e(old('facebook', $settings->facebook)); ?>"
                        placeholder="Facebook"
                        class="border border-slate-200 rounded-xl p-4"
                    >

                    <input
                        type="url"
                        name="instagram"
                        value="<?php echo e(old('instagram', $settings->instagram)); ?>"
                        placeholder="Instagram"
                        class="border border-slate-200 rounded-xl p-4"
                    >

                    <input
                        type="url"
                        name="linkedin"
                        value="<?php echo e(old('linkedin', $settings->linkedin)); ?>"
                        placeholder="LinkedIn"
                        class="border border-slate-200 rounded-xl p-4"
                    >

                    <input
                        type="url"
                        name="tiktok"
                        value="<?php echo e(old('tiktok', $settings->tiktok)); ?>"
                        placeholder="TikTok"
                        class="border border-slate-200 rounded-xl p-4"
                    >

                    <input
                        type="url"
                        name="youtube"
                        value="<?php echo e(old('youtube', $settings->youtube)); ?>"
                        placeholder="YouTube"
                        class="border border-slate-200 rounded-xl p-4"
                    >

                </div>

                

                <h2 class="text-2xl font-black text-[#0A2E5D] mt-12 mb-6">
                    SEO
                </h2>

                <div class="space-y-6">

                    <input
                        type="text"
                        name="meta_title"
                        value="<?php echo e(old('meta_title', $settings->meta_title)); ?>"
                        placeholder="Titre SEO"
                        class="w-full border border-slate-200 rounded-xl p-4"
                    >

                    <textarea
                        name="meta_description"
                        rows="4"
                        placeholder="Description SEO"
                        class="w-full border border-slate-200 rounded-xl p-4"
                    ><?php echo e(old('meta_description', $settings->meta_description)); ?></textarea>

                </div>

                <button
                    type="submit"
                    class="mt-10 rounded-full bg-[#C89B3C] px-8 py-4 font-bold text-white hover:bg-[#A87F2E] transition"
                >
                    Enregistrer les paramètres
                </button>

            </form>

        </div>

    </div>

</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/admin/site-settings/edit.blade.php ENDPATH**/ ?>
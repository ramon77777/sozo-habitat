<section
    class="relative min-h-screen bg-cover bg-center"
    style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c');"
>
    <div class="absolute inset-0 bg-black/60"></div>

    <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>

    <div class="relative z-10 flex min-h-screen flex-col items-center justify-center px-6 text-center text-white">
        <p class="mb-5 text-sm font-semibold uppercase tracking-[0.35em] text-[#C89B3C]">
            Sozo Habitat
        </p>

        <h1 class="max-w-5xl text-5xl font-black leading-tight md:text-7xl">
            Trouvez le bien de vos rêves
        </h1>

        <p class="mt-6 max-w-2xl text-base text-slate-200 md:text-lg">
            Achat, vente, location et gestion immobilière partout en Côte d'Ivoire.
        </p>

        <div class="mt-10 w-full flex justify-center">
            <?php if (isset($component)) { $__componentOriginal2ce1ea087e0510c66fba14e209f96469 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ce1ea087e0510c66fba14e209f96469 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-box','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ce1ea087e0510c66fba14e209f96469)): ?>
<?php $attributes = $__attributesOriginal2ce1ea087e0510c66fba14e209f96469; ?>
<?php unset($__attributesOriginal2ce1ea087e0510c66fba14e209f96469); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ce1ea087e0510c66fba14e209f96469)): ?>
<?php $component = $__componentOriginal2ce1ea087e0510c66fba14e209f96469; ?>
<?php unset($__componentOriginal2ce1ea087e0510c66fba14e209f96469); ?>
<?php endif; ?>
        </div>
    </div>
</section><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/components/hero.blade.php ENDPATH**/ ?>
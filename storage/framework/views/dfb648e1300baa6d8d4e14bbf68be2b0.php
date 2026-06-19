<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <?php echo $__env->yieldContent('seo'); ?>

    <?php if(!View::hasSection('seo')): ?>
        <?php if (isset($component)) { $__componentOriginala2d9072d59b69a761b60324b3706ddf1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2d9072d59b69a761b60324b3706ddf1 = $attributes; } ?>
<?php $component = App\View\Components\Seo::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Seo::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2d9072d59b69a761b60324b3706ddf1)): ?>
<?php $attributes = $__attributesOriginala2d9072d59b69a761b60324b3706ddf1; ?>
<?php unset($__attributesOriginala2d9072d59b69a761b60324b3706ddf1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2d9072d59b69a761b60324b3706ddf1)): ?>
<?php $component = $__componentOriginala2d9072d59b69a761b60324b3706ddf1; ?>
<?php unset($__componentOriginala2d9072d59b69a761b60324b3706ddf1); ?>
<?php endif; ?>
    <?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/logo.png')); ?>">

    <title>
        <?php echo $__env->yieldContent('title', 'SOZO Habitat | Immobilier en Côte d’Ivoire : Villas, Maisons et Terrains'); ?>
    </title>


    <meta name="description"
      content="<?php echo $__env->yieldContent('description', 'SOZO Habitat vous accompagne dans vos projets immobiliers en Côte d’Ivoire : achat, vente et location de villas, maisons, appartements et terrains.'); ?>">


    <meta name="keywords"
      content="immobilier Côte d'Ivoire, maison à vendre Côte d'Ivoire, villa à vendre Côte d'Ivoire, terrain à vendre Côte d'Ivoire, location appartement Côte d'Ivoire, SOZO Habitat">


    <meta property="og:title"
      content="<?php echo $__env->yieldContent('title', 'SOZO Habitat | Immobilier en Côte d’Ivoire'); ?>">


    <meta property="og:description"
      content="<?php echo $__env->yieldContent('description', 'SOZO Habitat vous accompagne dans vos projets immobiliers en Côte d’Ivoire.'); ?>">


    <meta property="og:type"
        content="website">


    <meta property="og:image"
        content="<?php echo e(asset('images/logo.png')); ?>">


    <meta name="twitter:card"
        content="summary_large_image">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="font-sans antialiased bg-[#F8F9FB] text-slate-900">

    <?php if(request()->is('admin*')): ?>
        <div class="flex min-h-screen">
            <?php if (isset($component)) { $__componentOriginal6fc2d165f80d597f34aa0f8014c366d2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2)): ?>
<?php $attributes = $__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2; ?>
<?php unset($__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6fc2d165f80d597f34aa0f8014c366d2)): ?>
<?php $component = $__componentOriginal6fc2d165f80d597f34aa0f8014c366d2; ?>
<?php unset($__componentOriginal6fc2d165f80d597f34aa0f8014c366d2); ?>
<?php endif; ?>

            <main class="flex-1 overflow-x-hidden">
                <?php if(isset($slot)): ?>
                    <?php echo e($slot); ?>

                <?php else: ?>
                    <?php echo $__env->yieldContent('content'); ?>
                <?php endif; ?>
            </main>
        </div>
    <?php else: ?>
        <?php if(isset($slot)): ?>
            <?php echo e($slot); ?>

        <?php else: ?>
            <?php echo $__env->yieldContent('content'); ?>
        <?php endif; ?>
    <?php endif; ?>

</body>
</html><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/layouts/app.blade.php ENDPATH**/ ?>
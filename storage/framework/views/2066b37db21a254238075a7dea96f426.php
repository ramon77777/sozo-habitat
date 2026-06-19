<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Sozo Habitat Agent</title>

<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?>

</head>


<body class="bg-slate-100">


<div class="flex min-h-screen">


    <?php if (isset($component)) { $__componentOriginale2823a77a80ec4af8282b6bd4f794298 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2823a77a80ec4af8282b6bd4f794298 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.agent-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('agent-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale2823a77a80ec4af8282b6bd4f794298)): ?>
<?php $attributes = $__attributesOriginale2823a77a80ec4af8282b6bd4f794298; ?>
<?php unset($__attributesOriginale2823a77a80ec4af8282b6bd4f794298); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale2823a77a80ec4af8282b6bd4f794298)): ?>
<?php $component = $__componentOriginale2823a77a80ec4af8282b6bd4f794298; ?>
<?php unset($__componentOriginale2823a77a80ec4af8282b6bd4f794298); ?>
<?php endif; ?>



    <main class="flex-1 p-10">


        <?php echo $__env->yieldContent('content'); ?>


    </main>


</div>


</body>

</html><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/layouts/agent.blade.php ENDPATH**/ ?>
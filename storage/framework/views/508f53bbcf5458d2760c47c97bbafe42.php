<nav class="absolute top-0 left-0 z-50 w-full px-8 md:px-14 py-6">
    <div class="flex items-center justify-between">

        <a href="/" class="text-2xl md:text-3xl font-black tracking-tight text-[#C89B3C]">
            <?php echo e($siteSettings->site_name ?? 'Sozo Habitat'); ?>

        </a>

        <div class="hidden md:flex items-center gap-10 text-sm font-semibold text-white">

            <a href="/" class="hover:text-[#C89B3C] transition">
                Accueil
            </a>

            <a href="<?php echo e(route('properties.index')); ?>"
               class="hover:text-[#C89B3C] transition">
                Biens
            </a>

            <a href="<?php echo e(route('properties.index', ['transaction' => 'vente'])); ?>"
               class="hover:text-[#C89B3C] transition">
                Acheter
            </a>

            <a href="<?php echo e(route('properties.index', ['transaction' => 'location'])); ?>"
               class="hover:text-[#C89B3C] transition">
                Louer
            </a>

            <a href="#contact"
               class="hover:text-[#C89B3C] transition">
                Contact
            </a>

            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                   class="rounded-full bg-[#C89B3C] px-5 py-2 text-white hover:bg-[#A87F2E] transition">
                    Admin
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"
                   class="rounded-full border border-white/40 px-5 py-2 text-white hover:bg-white hover:text-[#0A2E5D] transition">
                    Connexion
                </a>
            <?php endif; ?>

        </div>
    </div>
</nav><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/components/navbar.blade.php ENDPATH**/ ?>
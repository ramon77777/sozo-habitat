

<?php $__env->startSection('content'); ?>

<section class="min-h-screen bg-[#F8F9FB] px-6 py-10">

    <div class="max-w-7xl mx-auto">


        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-10">

            <div>
                <p class="text-[#C89B3C] font-bold uppercase tracking-[0.3em]">
                    Administration
                </p>

                <h1 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    Gestion des clients potentiels
                </h1>
            </div>


            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="rounded-full border border-[#0A2E5D] px-6 py-3 font-bold text-[#0A2E5D] hover:bg-[#0A2E5D] hover:text-white transition">

                Retour dashboard

            </a>


        </div>



        

        <?php if(session('success')): ?>

            <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 p-5 text-green-700">
                <?php echo e(session('success')); ?>

            </div>

        <?php endif; ?>



        

        <div class="grid md:grid-cols-5 gap-6 mb-10">


            <div class="bg-white rounded-3xl shadow p-6">
                <p class="text-slate-500">
                    Total
                </p>

                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    <?php echo e($totalProspects); ?>

                </h2>
            </div>



            <div class="bg-white rounded-3xl shadow p-6">

                <p class="text-slate-500">
                    Nouveaux
                </p>

                <h2 class="text-4xl font-black text-green-600 mt-3">
                    <?php echo e($newProspects); ?>

                </h2>

            </div>



            <div class="bg-white rounded-3xl shadow p-6">

                <p class="text-slate-500">
                    Contactés
                </p>

                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    <?php echo e($contactedProspects); ?>

                </h2>

            </div>



            <div class="bg-white rounded-3xl shadow p-6">

                <p class="text-slate-500">
                    Visites
                </p>

                <h2 class="text-4xl font-black text-[#C89B3C] mt-3">
                    <?php echo e($visitProspects); ?>

                </h2>

            </div>



            <div class="bg-white rounded-3xl shadow p-6">

                <p class="text-slate-500">
                    Convertis
                </p>

                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    <?php echo e($convertedProspects); ?>

                </h2>

            </div>


        </div>




        


        <div class="bg-white rounded-3xl shadow p-6 mb-8">


            <form method="GET"
                  action="<?php echo e(route('admin.prospects.index')); ?>"
                  class="flex flex-col md:flex-row gap-4">


                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Nom, téléphone ou email..."
                    class="flex-1 rounded-2xl border border-slate-200 px-5 py-4"
                >



                <select
                    name="status"
                    class="rounded-2xl border border-slate-200 px-5 py-4">


                    <option value="">
                        Tous les statuts
                    </option>

                    <option value="nouveau"
                    <?php if(request('status') === 'nouveau'): echo 'selected'; endif; ?>>
                        Nouveau
                    </option>


                    <option value="contacte"
                    <?php if(request('status') === 'contacte'): echo 'selected'; endif; ?>>
                        Contacté
                    </option>


                    <option value="visite"
                    <?php if(request('status') === 'visite'): echo 'selected'; endif; ?>>
                        Visite
                    </option>


                    <option value="negociation"
                    <?php if(request('status') === 'negociation'): echo 'selected'; endif; ?>>
                        Négociation
                    </option>


                    <option value="converti"
                    <?php if(request('status') === 'converti'): echo 'selected'; endif; ?>>
                        Converti
                    </option>


                    <option value="perdu"
                    <?php if(request('status') === 'perdu'): echo 'selected'; endif; ?>>
                        Perdu
                    </option>


                </select>



                <button
                    type="submit"
                    class="rounded-2xl bg-[#0A2E5D] px-8 py-4 font-bold text-white hover:bg-[#071F3F] transition">

                    Rechercher

                </button>


            </form>


        </div>





        


        <div class="bg-white rounded-3xl shadow overflow-hidden">


            <div class="overflow-x-auto">


                <table class="w-full text-left">


                    <thead class="bg-slate-50 text-[#0A2E5D]">


                        <tr>

                            <th class="p-5">
                                Nom
                            </th>

                            <th class="p-5">
                                Contact
                            </th>

                            <th class="p-5">
                                Bien
                            </th>

                            <th class="p-5">
                                Statut
                            </th>

                            <th class="p-5">
                                Date
                            </th>

                            <th class="p-5">
                                Action
                            </th>


                        </tr>


                    </thead>




                    <tbody>


                    <?php $__empty_1 = true; $__currentLoopData = $prospects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prospect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


                        <tr class="border-t border-slate-100">


                            <td class="p-5 font-bold text-[#0A2E5D]">

                                <?php echo e($prospect->name); ?>


                            </td>



                            <td class="p-5 text-slate-600">


                                <div>
                                    <?php echo e($prospect->phone); ?>

                                </div>

                                <div>
                                    <?php echo e($prospect->email); ?>

                                </div>


                            </td>




                            <td class="p-5">


                                <?php if($prospect->property): ?>

                                    <a href="<?php echo e(route('properties.show',$prospect->property)); ?>"
                                       class="font-bold text-[#0A2E5D]">

                                        <?php echo e($prospect->property->title); ?>


                                    </a>


                                <?php else: ?>

                                    -

                                <?php endif; ?>


                            </td>




                            <td class="p-5">


                                <form method="POST"
                                      action="<?php echo e(route('admin.prospects.update-status',$prospect)); ?>"


                                    <?php echo csrf_field(); ?>

                                    <?php echo method_field('PATCH'); ?>


                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="rounded-xl border border-slate-200 px-3 py-2">


                                        <?php $__currentLoopData = [
                                            'nouveau'=>'Nouveau',
                                            'contacte'=>'Contacté',
                                            'visite'=>'Visite',
                                            'negociation'=>'Négociation',
                                            'converti'=>'Converti',
                                            'perdu'=>'Perdu'
                                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                            <option value="<?php echo e($key); ?>"
                                            <?php if($prospect->status === $key): echo 'selected'; endif; ?>>

                                                <?php echo e($label); ?>


                                            </option>


                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </select>


                                </form>


                            </td>




                            <td class="p-5 text-slate-600">


                                <?php echo e($prospect->created_at->format('d/m/Y')); ?>



                            </td>




                            <td class="p-5">


                                <a href="tel:<?php echo e($prospect->phone); ?>"
                                   class="font-bold text-green-700">

                                    Appeler

                                </a>


                            </td>


                        </tr>



                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


                        <tr>

                            <td colspan="6"
                                class="p-8 text-center text-slate-500">

                                Aucun prospect trouvé.

                            </td>


                        </tr>


                    <?php endif; ?>



                    </tbody>


                </table>



            </div>




            <div class="p-6 border-t border-slate-100">

                <?php echo e($prospects->links()); ?>


            </div>



        </div>



    </div>


</section>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/admin/prospects/index.blade.php ENDPATH**/ ?>
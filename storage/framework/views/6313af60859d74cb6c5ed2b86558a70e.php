

<?php $__env->startSection('content'); ?>


<div class="p-8">


    <h1 class="text-4xl font-black text-[#0A2E5D]">
        Mes clients
    </h1>


    <p class="text-slate-500 mt-2">
         Clients qui vous sont affectés
    </p>




    <div class="mt-10 bg-white rounded-3xl shadow p-6">


        <table class="w-full">


            <thead>


                <tr class="border-b text-left">


                    <th class="p-3">
                        Nom
                    </th>


                    <th>
                        Téléphone
                    </th>


                    <th>
                        Email
                    </th>


                    <th>
                        Statut
                    </th>


                </tr>


            </thead>




            <tbody>



            <?php $__empty_1 = true; $__currentLoopData = $prospects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prospect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>



                <tr class="border-b">


                    <td class="p-3 font-bold">

                        <?php echo e($prospect->name); ?>


                    </td>



                    <td>

                        <?php echo e($prospect->phone); ?>


                    </td>



                    <td>

                        <?php echo e($prospect->email ?? '-'); ?>


                    </td>




                    <td>


                        <span class="px-3 py-1 rounded-full bg-slate-100">

                            <?php echo e($prospect->status); ?>


                        </span>


                    </td>



                </tr>




                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


                <tr>

                    <td colspan="4"
                        class="p-5 text-center text-slate-400">

                        Aucun client

                    </td>


                </tr>


            <?php endif; ?>



            </tbody>


        </table>


    </div>



    <div class="mt-6">

        <?php echo e($prospects->links()); ?>


    </div>



</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/agent/prospects/index.blade.php ENDPATH**/ ?>
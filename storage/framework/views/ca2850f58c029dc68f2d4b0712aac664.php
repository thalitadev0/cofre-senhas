<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Minhas Senhas</h1>

    <a href="<?php echo e(route('passwords.create')); ?>" class="btn btn-primary mb-3">Adicionar Nova Senha</a>
    
    <a href="<?php echo e(route('passwords.export')); ?>" class="btn btn-outline-secondary mb-3">Exportar Senhas</a>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($passwords->count()): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>URL</th>
                    <th>Usuário</th>
                    <th>Senha</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                
                <?php $__currentLoopData = $passwords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $password): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($password->title); ?></td>
                    <td><?php echo e($password->url); ?></td>
                    <td><?php echo e($password->username); ?></td>
                    <td>
                        ********
                        <a href="<?php echo e(route('passwords.show', $password->id)); ?>">Mostrar</a>
                    </td>
                    <td>
                        <a href="<?php echo e(route('passwords.edit', $password->id)); ?>" class="btn btn-sm btn-warning">Editar</a>
                        <form action="<?php echo e(route('passwords.destroy', $password->id)); ?>" method="POST" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Você ainda não tem senhas cadastradas.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projetos\cofre-senhas-final\resources\views/passwords/index.blade.php ENDPATH**/ ?>
<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerApQkD7M\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerApQkD7M/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerApQkD7M.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerApQkD7M\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerApQkD7M\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'ApQkD7M',
    'container.build_id' => 'd9a0b6ff',
    'container.build_time' => 1580953396,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerApQkD7M');
<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerHcFDOik\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerHcFDOik/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerHcFDOik.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerHcFDOik\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerHcFDOik\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'HcFDOik',
    'container.build_id' => '6a3a83f6',
    'container.build_time' => 1581639105,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerHcFDOik');

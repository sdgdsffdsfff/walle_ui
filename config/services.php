<?php
$container = new \yii\di\Container();

$container->set('Foo', function () {
    return new Foo(new Bar);
});
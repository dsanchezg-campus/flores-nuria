<?php

use PHPUnit\Framework\TestCase;

class ProductoTest extends TestCase
{
    public function testProducto(): void{
        $productos = Producto::getProductos();
        $this->assertIsArray($productos);
//        $this->assertNotEmpty($productos);

        foreach ($productos as $producto) {
//            $this->assertInstanceOf(Producto::class, $producto);
            $this->assertIsString($producto->getNombre());
        }
    }
}

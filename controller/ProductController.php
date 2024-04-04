<?php

require_once 'model/Product.php'; // Asegúrate de incluir el camino correcto

class ProductController {
    private $productModel;

    public function __construct($db) {
        $this->productModel = new Product($db);
    }

    // Método para mostrar todos los productos
    public function listProducts() {
        $products = $this->productModel->readAll();
        include 'view/admin/manage_product.php'; // Asumiendo que tienes una vista para esto
    }

    // Método para agregar un nuevo producto
    public function addProduct($name, $quantity, $price, $imgUrl, $description) {
        $this->productModel->name = $name;
        $this->productModel->quantity = $quantity;
        $this->productModel->price = $price;
        $this->productModel->img_url = $imgUrl;
        $this->productModel->description = $description;

        if ($this->productModel->create()) {
            echo "Producto agregado exitosamente.";
            // Redirige al usuario a la página de lista de productos o muestra un mensaje de éxito
        } else {
            echo "Ocurrió un error al agregar el producto.";
            // Muestra un mensaje de error
        }
    }

    // Método para editar un producto existente
    public function editProduct($id, $name, $quantity, $price, $imgUrl, $description) {
        // Aquí implementarías la lógica para actualizar un producto existente
        // Esto incluiría obtener el producto por su ID, actualizar sus propiedades y guardar los cambios
    }

    // Método para eliminar un producto
    public function deleteProduct($id) {
        // Aquí implementarías la lógica para eliminar un producto
        // Esto incluiría obtener el producto por su ID y eliminarlo de la base de datos
    }
}
?>

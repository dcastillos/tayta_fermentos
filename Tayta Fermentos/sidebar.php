<?php
include 'db.php';

$query_categorias = "SELECT codigo, nombre FROM categoria";
$result_categorias = $conn->query($query_categorias);
?>

<div class="sidebar-box ftco-animate">
    <div class="categories">
        <h3>Tipos de Productos</h3>
        <ul class="p-0">
            <?php while ($row = $result_categorias->fetch_assoc()): ?>
                <li>
                    <a href="product.php?categoria=<?php echo $row['codigo']; ?>">
                        <?php echo htmlspecialchars($row['nombre']); ?>
                        <span class="fa fa-chevron-right"></span>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>


<div class="sidebar-box ftco-animate">
    <h3>Blog</h3>
    <div class="block-21 mb-4 d-flex">
        <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
        <div class="text">
            <h3 class="heading"><a href="#">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque labore eos facere</a></h3>
            <div class="meta">
                <div><a href="#"><span class="fa fa-calendar"></span> Apr. 18, 2020</a></div>
                <div><a href="#"><span class="fa fa-comment"></span> 19</a></div>
            </div>
        </div>
    </div>
    <div class="block-21 mb-4 d-flex">
        <a class="blog-img mr-4" style="background-image: url(images/image_2.jpg);"></a>
        <div class="text">
            <h3 class="heading"><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur.</a></h3>
            <div class="meta">
                <div><a href="#"><span class="fa fa-calendar"></span> Apr. 18, 2020</a></div>
                <div><a href="#"><span class="fa fa-comment"></span> 19</a></div>
            </div>
        </div>
    </div>
    <div class="block-21 mb-4 d-flex">
        <a class="blog-img mr-4" style="background-image: url(images/image_3.jpg);"></a>
        <div class="text">
            <h3 class="heading"><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, .</a></h3>
            <div class="meta">
                <div><a href="#"><span class="fa fa-calendar"></span> Apr. 18, 2020</a></div>
                <div><a href="#"><span class="fa fa-comment"></span> 19</a></div>
            </div>
        </div>
    </div>
</div>

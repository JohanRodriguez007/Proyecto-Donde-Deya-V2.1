
<body>

<div class="d-flex justify-content-end position-fixed top-0 end-0 m-3">
    <a href="index.php?vista=login" class="btn btn-primary me-2">Iniciar Sesión</a>
    <a href="index.php?vista=customer_new" class="btn btn-primary">Registrarse</a>
</div>

        <div class="container-icon">
            <div class="title">Sobre Nosotros...</div>
            </div>
    
     
            
 
        <div class="container-slider">

            <div class="slider">
    
                <input type="radio" name="slider" id="slide-uno" checked>
                <input type="radio" name="slider" id="slide-dos">
                <input type="radio" name="slider" id="slide-tres">
    
                <div class="buttons">
                    <label for="slide-uno"></label>
                    <label for="slide-dos"></label>
                    <label for="slide-tres"></label>
                </div>
    
                <div class="content-slider">
                    <div class="primer-slide"></div>
                    <div class="segundo-slide"><H1></div>
                    <div class="tercer-slide"></div>
                </div>
    
            </div>
    
            <?php

            require './inc/footer.php'; 

            ?>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>


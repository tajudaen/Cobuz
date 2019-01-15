<?php require ROOT . DS . 'app' . DS . 'views' . DS . 'includes' . DS . 'header.php'; ?>
    <div class="card card-body bg-light mt-5 text-center">
    <h2>Play Game</h2>
    <hr>
    <div class="row">
        <div class="col-4">
            <h3>Rules</h3>
            <p>* Enter a 4 digit number, e.g 0000</p>
            <p>* if a number matches the position of the same digit in the system generated combination, you earn 1 cow</p>
            <p>* if a number from the entry exist in the system generated combination, you earn 1 bull</p>
        </div>
        <div class="col-4">
            <form action="<?php echo URLROOT; ?>game/run" method="post">
                <div class="form-group">
                    <input type="number" name="entry" class="form-control form-control-lg <?php echo (!empty($data['entry_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $data['entry_err']; ?></span>
                </div>
                
                <input type="submit" class="btn btn-success" value="Play">
            </form>
        </div>
        <div class="col-4">
            <h3>Result</h3>
            <?php if (isset($data['cow'])) : ?>
                <p><strong><?php echo $data['cow'] ?> </strong> Cow</p>
            <?php endif; ?>
            <?php if (isset($data['bull'])) : ?>
                <p><strong><?php echo $data['bull'] ?> </strong> Bull</p>
            <?php endif; ?>
            
            <?php if (isset($data['entry']) && !empty($data['entry'])) : ?>
                <p><strong>Entry </strong> - <i><?php echo $data['entry'] ?></i></p>
            <?php endif; ?>
            
            <?php if (isset($data['engine'])) : ?>
                <p><strong>System Generated </strong> - <i><?php echo $data['engine'] ?></i></p>
            <?php endif; ?>
            
        </div>
    </div>
  </div>
<?php require ROOT . DS . 'app' . DS . 'views' . DS . 'includes' . DS . 'footer.php'; ?>
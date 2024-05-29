<?php
//cabecalho
function breadcrumbs($items){
ob_start();
?>
<div class="col-sm-12 row">
    <div class="col-sm-4 elementHeader">
        <select class="form-control" name="selectOptions">
            <option value=''>Opções</option>
            <?php
            foreach($items as $key => $val){
                echo "<option value='$key'>$val</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-sm-4 elementHeader">
       <select name="qtShow" class="form-control">
        <option value="">Quantidade</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
       </select>
    </div>
    <div class="col-sm-4 elementHeader">
        <input name='pesquisa' class='form-control' placeholder='Pesquisar..'>
    </div>
</div>
<br>
<hr width="100%">
<?php
    echo ob_get_clean();
}
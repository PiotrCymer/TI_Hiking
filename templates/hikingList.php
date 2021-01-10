<div class="row">
    <div class="col-md-12">
        <h3>Lista wędrówek</h3>
    </div>
</div>
<?php if (isset($_SESSION['messages']['hikingAdded']) && $_SESSION['messages']['hikingAdded']): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success text-center" role="alert">
                Wędrówka została dodana dodana pomyślnie!
            </div>
        </div>
    </div>
<?php endif;
unset($_SESSION['messages']['hikingAdded']); ?>
<div class="row">
    <div class="col-md-9 form-group">
        <select id="sortOrder" class="form-control">
            <option value="fromOldest">Od najstarszych</option>
            <option value="fromNewest">Od najnowszych</option>
        </select>
    </div>
    <div class="col-md-3">
        <button class="btn btn-secondary w-100" id="sortBtn">Sortuj</button>
    </div>
</div>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Losowe zdjęcie</th>
        <th scope="col">Nazwa wędrówki</th>
        <th scope="col">Data rozpoczęcia</th>
        <th scope="col">Handle</th>
    </tr>
    </thead>
    <tbody id="tableBody">
    <?php include($_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "hikingListData.php"); ?>
    </tbody>
</table>

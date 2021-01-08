<form method="post" id="newHikingForm">
    <input type="hidden" name="action" value="add">
    <div class="row">
        <div class="md-12">
            <div class="alert alert-danger" role="alert" id="newHikingError"></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="hikingName">Nazwa wędrówki</label>
            <input type="text" class="form-control" id="hikingName" name="hikingName" placeholder="Nazwa wędrówki">
        </div>
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-6">
            <label for="startDate">Data rozpoczęcia wędrówki</label>
            <input type="date" class="form-control" id="startDate" name="hikingStartDate"
                   placeholder="Data rozpoczęcia wędrówki">
        </div>
        <div class="form-group col-md-6">
            <label for="endDate">Data końca wędrówki</label>
            <input type="date" class="form-control" id="endDate" name="hikingEndDate" placeholder="Data końca wędrówki">
        </div>
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-6">
            <label for="startPlace">Miejsce startu wędrówki</label>
            <input type="text" class="form-control" id="startPlace" name="hikingStartPlace"
                   placeholder="Miejsce startu wędrówki">
        </div>
        <div class="form-group col-md-6">
            <label for="endPlace">Miejsce końca wędrówki</label>
            <input type="text" class="form-control" id="endPlace" name="hikingEndPlace"
                   placeholder="Miejsce końca wędrówki">
        </div>
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-12">
            <label for="length">Długość wędrówki (w km)</label>
            <input type="text" class="form-control" id="length" name="hikingLength" placeholder="Długość wędrówki">
        </div>
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-12">
            <label for="length">Zdjęcia z wędrówki (max 6)</label>
            <input type="file" name="hikingImages[]" id="hikingImages" multiple>
        </div>
    </div>
    <div class="row mt-4 imagesPreview"></div>
    <div class="row mt-4">
        <div class="form-group col-md-12">
            <label for="length">Film z wędrówki (max 1)</label>
            <input type="file" name="hikingVideo" id="hikingVideo">
        </div>
    </div>
    <div class="row mt-4 videoPreview">
        <video width="400" controls id="hikingVideoPreview">
            Your browser does not support HTML5 video.
        </video>
    </div>

    <button type="submit" class="btn btn-primary mt-4 saveHiking">Zapisz wędrówke</button>


</form>

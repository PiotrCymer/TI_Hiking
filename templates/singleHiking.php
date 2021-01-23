<?php if ($noHiking): ?>
    <div class="alert alert-danger text-center mt-4" role="alert">
        Wybrana wędrówka nie istnieje
    </div>
<?php else: ?>
    <form>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="hikingName">Nazwa wędrówki</label>
                <input type="text" class="form-control" id="hikingName" value="<?php echo $hiking->getName(); ?>"
                       disabled>
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group col-md-6">
                <label for="startDate">Data rozpoczęcia wędrówki</label>
                <input class="form-control" id="startDate"
                       value="<?php echo $hiking->getStartDate()->format('Y-m-d H:i:s'); ?>" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="endDate">Data końca wędrówki</label>
                <input type="date" class="form-control" id="endDate"
                       value="<?php echo $hiking->getEndDate()->format('Y-m-d H:i:s'); ?>" disabled>
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group col-md-6">
                <label for="startPlace">Miejsce startu wędrówki</label>
                <input type="text" class="form-control" id="startPlace"
                       value="<?php echo $hiking->getStartingPoint(); ?>" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="endPlace">Miejsce końca wędrówki</label>
                <input type="text" class="form-control" id="endPlace"
                       value="<?php echo $hiking->getDestination(); ?>" disabled>
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group col-md-12">
                <label for="length">Długość wędrówki (w km)</label>
                <input type="text" class="form-control" id="length" name="hikingLength"
                       value="<?php echo $hiking->getLength(); ?>" disabled>
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group col-md-12">
                <label>Zdjęcia z wędrówki</label>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <?php if (count($hikingImages) == 0): ?>
                    <div class="alert alert-primary" role="alert">
                        Ta wędrówka nie posiada żadnych zdjeć
                    </div>
                <?php else: ?>
                <div class="row">
                    <?php foreach ($hikingImages as $k => $v): ?>
                        <div class='col-md-4 mt-2'><img style="max-width: 100%;" src='<?php echo $v; ?>'/></div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group col-md-12">
                <label>Film z wędrówki</label>
            </div>
        </div>
        <?php if ($hiking->getVideo()): ?>
            <div class="row mt-4 videoPreview">
                <video width="400" controls id="hikingVideoPreview">
                    <source src="<?php echo $hiking->getVideo();?>" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>
        <?php else: ?>
            <div class="alert alert-primary" role="alert">
                Ta wędrówka nie posiada wideo
            </div>
        <?php endif; ?>


    </form>
<?php endif; ?>

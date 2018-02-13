<section id="list">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center py-3">Create Container</h5>
                    <div class="container">
                        <?= form_open('containers/create'); ?>
                            <div class="form-row pt-3">
                                <div class="col">
                                    <input type="text" name="container_number" class="form-control" placeholder="Type container number">
                                    <small class="form-text text-muted pl-1">This field is the GBR number (##-####).</small>
                                </div>
                                <div class="col">
                                    <input type="text" name="container_serial_number" class="form-control" placeholder="Type container serial number">
                                    <small class="form-text text-muted pl-1">This field is the serial number of the container.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="container_shelves" name="container_shelves">
                                        <label class="custom-control-label" for="container_shelves">Container has shelves?</label>
                                    </div>
                                    <small class="form-text text-muted pl-1">Check the box if container has shelves.</small>
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="container_painted" name="container_painted">
                                        <label class="custom-control-label" for="container_painted">Container is painted?</label>
                                    </div>
                                    <small class="form-text text-muted pl-1">Check the box if container is painted.</small>
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="container_onbox_numbers" name="container_onbox_numbers">
                                        <label class="custom-control-label" for="container_onbox_numbers">Container has GBR numbers?</label>
                                    </div>
                                    <small class="form-text text-muted pl-1">Check the box if container has GBR numbers.</small>
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="container_signs" name="container_signs">
                                        <label class="custom-control-label" for="container_signs">Container has signs?</label>
                                    </div>
                                    <small class="form-text text-muted pl-1">Check the box if container has signs.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col">
                                    <input type="text" name="container_size" class="form-control" placeholder="Type container's size.">
                                    <small class="form-text text-muted pl-1">Type the container's size using numbers only. (20 for 20 foot container)</small>
                                </div>
                                <div class="col">
                                    <input type="text" name="release_number" class="form-control" placeholder="Type the container's release number.">
                                    <small class="form-text text-muted pl-1">Type the container's release number.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col">
                                    <select class="form-control" name="rental_resale" id="rental_resale">
                                        <option selected>Choose One</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Resale">Resale</option>
                                    </select>
                                    <small class="form-text text-muted pl-1">Select whether or not the container is a rental or resale container.</small>
                                </div>
                                <div class="col"></div>
                            </div>
                        <?= form_close(); ?>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-default form-button">Create</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default form-button">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
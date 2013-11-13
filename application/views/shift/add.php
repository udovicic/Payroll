            <script>jQuery('#menu-add').addClass('active');</script>
            <form class="shift" role="form">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="text" class="form-control" id="date" placeholder="Datum" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group row">        
                    <div class="col-sm-4">
                        <div class="input-group multiple-form-row">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-step-backward"></span></span>
                            <input type="text" class="form-control" id="start" placeholder="Početak" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group multiple-form-row">
                            <input type="text" class="form-control" id="end" placeholder="Kraj" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-step-forward"></span></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group multiple-form-row">
                            <input type="text" class="form-control" id="bonus" placeholder="Bonus">
                            <span class="input-group-addon">Kn</span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <input type="text" class="form-control" id="note" placeholder="Komentar">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-7 col-sm-5">
                        <button type="submit" class="btn btn-lg btn-primary btn-block">Spremi</button>
                    </div>
                </div>
                <div class="form-group" id="result" style="display:none">
                    <label class="col-sm-2 control-label">Sažetak</label>
                    <div class="col-sm-offset-2 col-sm-10">
                        <p class="form-control-static">1 Noćni</p>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <p class="form-control-static">2 Dnevna</p>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <p class="form-control-static">3 Nedjeljni</p>
                    </div>
                    <label class="col-sm-2 control-label">Ukupno</label>
                    <div class="col-sm-offset-2 col-sm-10">
                        <p class="form-control-static">22.40 Kn</p>
                    </div>
                    <label class="col-sm-2 control-label">Komentar</label>
                    <div class="col-sm-offset-2 col-sm-10">
                        <p class="form-control-static">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis, laudantium.</p>
                    </div>

                </div>
            </form>

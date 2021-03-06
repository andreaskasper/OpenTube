<section class="card">
                    <div class="card-header">Anmelden</div>
                    <div class="card-body">
                        <form action="/<?=$_ENV["lang"] ?>/login" method="POST">
                            <INPUT type="hidden" name="act" value="login"/>
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address:</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password:</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="pwd" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Eingeloggt bleiben
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    anmelden
                                </button>
                                <a href="#" class="btn btn-link">
                                    Passwort vergessen?
                                </a>
                            </div>
                    </div>
                    </form>
                </div>
</section>
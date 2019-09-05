<!-- variables are sent from "app/Mail/SendMailable.php" -->
<!-- SendMailable is called create() in "app/Http/Controllers/Auth/RegisterController.php"
        // send mail to the new user
        Mail::to($data['email'])->send(new SendMailable($data['name'], $userNameOfEmployee,$data['password']));
        -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Employee</div>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Dear</label>
                        <label class="col-md-4 col-form-label text-md-right">{{ $name }}</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">User Name: </label>
                        <label class="col-md-4 col-form-label text-md-right">{{ $userName }}</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Password: </label>
                        <label class="col-md-4 col-form-label text-md-right">{{ $password }}</label>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
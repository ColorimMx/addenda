<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sesiones</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <div class="page-header text-center">
                <h1>Example Login <small>Developero</small></h1>
            </div>
            <form class="form-signin" method="post" action="manejador.php">
                <h2 class="form-signin-heading">Please sign in</h2>
                <label for="user" class="sr-only">User</label>
                <input type="text" name="user" class="form-control" placeholder="User Name" required>
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Sign in">
            </form>
        </div>
    </div>
</div>
</body>

<html>  
<head> 
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    
    <title>Welcome!</title>
</head>  
<body>  
    <div id="container">
    <nav class="navbar navbar-inverse">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">Qrisis App</a>
    </nav>

    <?php if(@$user_profile) { ?>
    <center>
   <div id="plc">
    <?php 
    
    echo "<p class='flogo'><b>Your unique link</b></p> <input class='form-control' readonly type='text' size='35' value=".site_url("appc/link?qid=".$user_profile['id']).">";
    $su=site_url("appc/share?qid=".$user_profile['id']);
    echo "<br><a class='btn btn-success btn-lg' href='$su'>Share</a><br>";
    echo "<br><a class='btn btn-danger btn-lg' href='$logout_url'>Logout</a>" ;
    ?>
    </div>
    <?php
     }
     else 
     {
        if(isset($login_url))
        {
      ?>
    
    <div id="plc">

    <a class="btn btn-primary btn-lg " href="<?= $login_url ?>">Login with facebook</a>
    <?php } }  
    if(isset($fbid))
    {
        echo "<div id='plc'>";
        echo "<p class='flogo'><b>$fbid</b></p>";
        $bu=base_url();
        echo "<a class='btn btn-success btn-lg ' href='$bu'>Go to homepage</a><br><br>" ;
        echo "<a class='btn btn-danger btn-lg ' href='$logout_url'>Logout</a>" ;
    }
    
    ?>
    </div>
</center>
    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <p class="flogo">CREATED BY <b>ABDUL QADIR</b></p>
    </nav>
</div>
</body>

</html>  

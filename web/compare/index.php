<!DOCTYPE html>
<html>
<head>
  <title>KaInvest - internship task</title>
  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<link href="../stylesheets/bootstrap.css" rel="stylesheet">
<link href="../stylesheets/main.css" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="../assets/js/html5shiv.js"></script>
<![endif]-->

<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
				<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
							   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  
  <link rel="stylesheet" href="../stylesheets/morris.css">
  <script src="../javascript/jquery.min.js"></script>
  <script src="../javascript/raphael-min.js"></script>
  <script src="../javascript/morris.min.js"></script>
  
  <link rel="stylesheet" href="../stylesheets/chartist.min.css">
  <link href="../stylesheets/bootstrap-responsive.css" rel="stylesheet">
  <link href="../stylesheets/bootstrap.min.css" rel="stylesheet">
  <link href="../stylesheets/dataTables.bootstrap.min.css" rel="stylesheet">

  <script type="text/javascript" language="javascript" src="../javascript/jquery-1.12.0.min.js"></script> 
  <script type="text/javascript" language="javascript" src="../javascript/jquery.dataTables.min.js"></script>
  <script type="text/javascript" language="javascript" src="../javascript/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" language="javascript" src="../javascript/dateRange.js"></script>
  <script type="text/javascript" class="init">
	
	$(document).ready(function() {
		$('#showResult').DataTable();
	} );

	</script>
	<script type="text/javascript">
	function convert(str) {
			var date = new Date(str),
			mnth = ("0" + (date.getMonth()+1)).slice(-2),
			day  = ("0" + date.getDate()).slice(-2);
			return [ date.getFullYear(), mnth, day ].join("-");
	}
	</script>
	
	<style type="text/css">
	body {
		padding-top: 20px;
		padding-bottom: 40px;
	}

	/* Custom container */
	.container-narrow {
		margin: 0 auto;
		max-width: 700px;
	}
	.container-narrow > hr {
		margin: 30px 0;
	}

	/* Main marketing message and sign up button */
	.jumbotron {
		margin: 60px 0;
		text-align: center;
	}
	.jumbotron h1 {
		font-size: 72px;
		line-height: 1;
	}
	.jumbotron .btn {
		font-size: 21px;
		padding: 14px 24px;
	}

	/* Supporting marketing content */
	.marketing {
		margin: 60px 0;
	}
	.marketing p + h4 {
		margin-top: 28px;
	}
	</style>
  
</head>

<body>
  <div class="container-narrow">

      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="/">Main</a></li>
          <li><a href="/compare">Compare</a></li>
        </ul>
        <h3 class="muted">KaInvest</h3>
      </div>

      <hr>

      <div class="jumbotron">
        <h1>Hello Kainos,<br />hello world!</h1>
        <p class="lead">This is the place, where you can compare your profits between investment funt and other investment.</p>
        <a class="btn btn-large btn-success" href="#">Start work today</a>
      </div>

      <hr>

      <div class="row-fluid marketing">
        <div class="span12">
		
		  <h4>Lorem ipsum dolor sit amet erat</h4>
          <p>Fusce aliquam at, nibh. Ut tempus orci sit amet, nonummy id, bibendum mi. Nam lacus. Vivamus lacus euismod orci pellentesque accumsan. Proin urna. Suspendisse ac libero. Proin ornare interdum, lacus. Vestibulum ante ipsum primis in ligula ut malesuada congue. Nam vestibulum tincidunt eu, urna. Donec congue. Maecenas tortor libero, fringilla fringilla enim. Aenean id nulla sed lorem libero, egestas quam eget gravida sem. Quisque urna. Aenean quis pede ultrices nec, mattis egestas, dapibus et, enim. Suspendisse a lacus. Aliquam ultricies viverra fermentum imperdiet ante et malesuada leo luctus et magnis dis parturient montes, nascetur ridiculus mus. Nunc felis. Pellentesque bibendum, tellus. Suspendisse justo augue ut tortor. Aliquam posuere nisl erat at nibh nulla erat velit vitae lacinia lacus. In bibendum nulla. Nullam imperdiet dignissim, tellus. Maecenas in augue. Fusce interdum. Nulla ante. Curabitur vitae metus. Nulla facilisi. Etiam nibh risus, consequat wisi. Integer euismod convallis auctor. Nam suscipit, erat volutpat. Donec rutrum vel, arcu. Donec orci. Ut eget tortor. Maecenas viverra elit semper feugiat. Proin aliquam purus. Class aptent taciti sociosqu ad litora torquent.</p>

      <hr>

      <div class="footer">
        <p>&copy; Bartosz Jasiński 2016</p>
      </div>

    </div> <!-- /container -->
</body>
</html>
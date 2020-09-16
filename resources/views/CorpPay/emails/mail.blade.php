<html>
<head></head>
<style type="text/css">
html{
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
*, *:before, *:after {
  -webkit-box-sizing: inherit;
  -moz-box-sizing: inherit;
  box-sizing: inherit;
  }
body{
	display: block;
	background-color: #f5f5f4; 
}
#mail_content{
	max-width: 800px;
	margin: 20px auto;
	padding: 20px;
	background-color: #fff;
}
.mail_head{
	text-align: center;
}
.mail_body{
	text-align: left;
}
.mail_foot{
	margin-top: 20px;
	border-top: 1px solid #ccc;
	text-align: left;
}
</style>
<body>
	<div id="mail_content">
		<div class="mail_head">
			<div class="">logo</div>
			<div class="">Company Name</div>
		</div>
		<div class="mail_body">{{$content}}</div>
		<div class="mail_foot">
			<div class="">Company_address</div>
		</div>
	</div>
</body>
</html>
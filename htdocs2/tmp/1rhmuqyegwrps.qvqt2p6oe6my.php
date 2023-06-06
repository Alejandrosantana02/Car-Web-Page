<!DOCTYPE html>
<html>]
    <head>
<style>
    body{text-align:center; color:aliceblue; margin: 0}
    section img {
    width: 550px;
    height: 300px;}
    #main {
        display: flex;
        background-color: red;
    }
    #sidebar {
        flex: 1;
        background-color: rgb(30, 24, 36);
        padding: .5em;
    }
    #content {
        flex: 4;
        background-color: rgb(215, 39, 39);
        padding: .5em;
    }
    div a {
        color: #fff;
    }
    #promo {
        align-content: flex-start;
        flex: 4;
        background-color: rgb(92, 71, 71);

    }
    .header {
			background-color: #333;
			color: #fff;
			padding: 20px;
			text-align: center;
    }
    nav a {
        padding: 3em;
        color: #fff;
        text-decoration: none;
    }
    nav b {
        color: #fff;
        text-decoration: none;
    }
    footer {
        flex: 4;
        background-color:  rgb(30, 24, 36);
        overflow: auto;
        border: white;
        padding: .5em;
    }
  

    
	</style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div id="sidebar">
        <header class="header container text-center">
            <h1>FASTEST CARS ON THE PLANET</h1>
        </header>
            <?php $log_action=$SESSION['email'] ? 'logout' : 'login'; ?>
                <nav>
                    <ul>
                    <a href="/">Home</a>
                    <a href="/collection">Collection</a>
                    <a href="/about">About</a>
					<a href="/<?= ($log_action) ?>?reroute=<?= (strtok($SERVER['REQUEST_URI'], '?')) ?>"><?= (ucfirst($log_action)) ?></a>
				
                </ul>
                </nav>
            </div>
            <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
        <div class="main">
            <div id="content">
                <?php echo $this->render($template,NULL,get_defined_vars(),0); ?>


    
        <div id="promo">
            <?php $ad=rand(0,7); ?>
            <a href="http://csc325.cornerstone.edu/ads.php?index=<?= ($ad) ?>&type=link">
            <img src="http://csc325.cornerstone.edu/ads.php?index=<?= ($ad) ?>&type=banner" style="max-width:300px; max-height:100px">
            </a>
        </div>
    
        <footer>
            <nav>
                <ul>
                <a>Terms of Use</a>
                <a>Policies</a>
                </ul>
                <p1>Copyrights Reserved to Alejandro Santana</p1>
            </nav>
        </footer>
        

















 
   

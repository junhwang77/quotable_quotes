<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quotes Main Page</title>
        <style media="screen">
            .box {
                display: inline-block;
                border: black solid 1px;
                border-radius: 5px;
                padding: 10px;
            }
            .boxi {
                vertical-align: top;
                display: inline-block;
                border: black solid 3px;
                border-radius: 5px;
                padding: 10px;

            }
        </style>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <h2>Welcome, <?= $logged_in['alias'] ?>!</h2>
      <p><a href="/">Logout</a></p>
      <div class="boxi">
          <h4>Quotable Quotes:</h4>
          <?php if (isset($all_quotes)) {
              foreach ($all_quotes as $quote) {
                  echo "<div class='box'>
                            <p>{$quote['author']}: {$quote['text']}</p>
                             <p>Posted by
                             <a href='/users/{$quote['users_id']}'> {$quote['maker']}</a></p><a class='btn btn-default' href='/add_to_fav/{$quote['id']}'>Add to My List</a>
                            </div><br>";
              }
          } ?>
      </div>
      <div class="boxi">
          <h4>Your Favorites:</h4>
          <?php if (isset($fav_quotes)) {
              foreach ($fav_quotes as $quote) {
                  echo "<div class='box'>
                            <p>{$quote['author']}: {$quote['text']}</p>
                             <p>Posted by
                             <a href='/users/{$quote['users_id']}'> {$quote['maker']}</a></p><a class='btn btn-default' href='/remove/{$quote['id']}'>Remove From My List</a>
                            </div><br>";
              }
          } ?>
      </div>
      <div class="">
          <h4>Contribute a Quote:</h4>

          <?php echo validation_errors(); ?>

          <?php echo form_open('/quotes/add'); ?>

          <p>Quoted By:</p>
          <input type="text" name="author" value="">
          <p>Message:</p>
          <textarea name="text" rows="8" cols="80"></textarea>
          <input type="submit" name="" value="Submit">

          </form>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>

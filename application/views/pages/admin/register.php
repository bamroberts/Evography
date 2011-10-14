 <?php defined ( 'SYSPATH' ) or die ( 'No direct access allowed.' ) ;

echo form::open ( null ) ;
echo form::label ('username', 'Username:');
echo form::input ('username', ($form['username'])); 
echo (empty ($errors ['username']))?'': $errors['username']; 
echo "<br />"; echo "<br />" ;

echo form::label ('password', 'Password:');
echo form::password ('password', ($form['password'])); 
echo (empty ($errors ['password']))?'': $errors ['password'];
echo "<br />"; echo "<br />" ;
echo form::label ('email', 'E-Mail:'); 
echo form::input ('email', ($form ['email'])); 
echo (empty ($errors ['email']))?'': $errors ['email']; 
echo "<br />"; echo "<br />" ;

// $captcha = Captcha::instance(); 
// if (! $captcha->Promoted ())
// {
//   echo '<p>';
//   echo $captcha->render(); // Shows the Captcha challenge (image / riddle / etc) 
//   echo '</ p>'; 
//   echo form::label('captcha_response', 'Code'); 
//   echo form::input ('captcha_response');
//   echo (empty($errors ['captcha_response']))?'': $errors ['captcha_response']; 
// }
echo "<br />"; 
echo form::submit ('Register', 'Register'); 
echo form::close ();
?>
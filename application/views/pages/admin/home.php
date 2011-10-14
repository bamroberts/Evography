
<p>Welcome back <b><?php echo Auth::instance()->get_user()->username; ?></b></p>
<div class="grids">
  <div class="grid-4">
    <h4>Things to do:</h4>
    <ul>
    	<li><a href="/admin/collection/add">Create a new collection</a></li>
<!--     	<li><a href="/admin/collection/">Manage your collections</a></li> -->        
      <li><b>Account</b></li>
    	<li><a href="/admin/user/details">Primary Account Details</a></li>
      <li><a href="/admin/payment">Payment Plan</a></li>	
      <li><a href="/admin/payment/history">Payment History</a></li>	
      <li><b>Configuration:</b></li>
    	<li><a href="/admin/default">Default options for new albums and images</a></li>	
    	<li><a href="/admin/domains">Custom domain names</a></li>
    	<li><a href="/admin/cart">Shopping and sales </a></li>
    	<li><a href="/admin/user/">User control</a></li>
    </ul>
  </div>
  <div class="grid-10">
      <h4>Your collections:</h4> 
      <?php echo $collections; ?>     
  </div>
</div>

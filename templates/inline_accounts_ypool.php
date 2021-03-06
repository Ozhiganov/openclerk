<?php
$account_data = array('exchange_name' => get_exchange_name('ypool'));
?>

<div class="instructions_add">
<h2>Adding a <?php echo $account_data['exchange_name']; ?> account</h2>

<ol class="steps">
  <li>Log into your <?php echo $account_data['exchange_name']; ?> account
    and visit your <a href="http://ypool.net/api_documentation?ct=2">API Documentation page</a>.<br>
    <img src="<?php echo htmlspecialchars(url_for('img/accounts/ypool1.png')); ?>"></li>

  <li>Copy and paste your <i>API Key</i> into the <a class="wizard_link" href="<?php echo htmlspecialchars(url_for('wizard_accounts_pools')); ?>">"Add new Mining Pool" form</a>, and click "Add account".<br>
    <img src="<?php echo htmlspecialchars(url_for('img/accounts/ypool2.png')); ?>"></li>
</ol>
</div>

<div class="instructions_safe">
<h2>Is it safe to provide <?php echo htmlspecialchars(get_site_config('site_name')); ?> a <?php echo $account_data['exchange_name']; ?> API key?</h2>

<ul>
  <li>At the time of writing, a <?php echo $account_data['exchange_name']; ?> API key can only be used to retrieve account balances and worker status;
    it should not be possible to perform transactions or change user details using the API key.</li>

  <li>Your <?php echo $account_data['exchange_name']; ?> API keys will <i>never</i> be displayed on the <?php echo htmlspecialchars(get_site_config('site_name')); ?>
    site, even if you have logged in.</li>

  <li>You may generate a new API token at any time by visiting your <a href="http://ypool.net/api_documentation?ct=2">API Documentation page</a>
    and resetting the key, which will revoke any existing access.<br>
    <img src="<?php echo htmlspecialchars(url_for('img/accounts/ypool_delete.png')); ?>"></li>
</ul>
</div>

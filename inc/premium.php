<?php

/**
 * Various functionality related to premium accounts and limits.
 */

function account_data_grouped() {
	return array(
		'Addresses' => array(
			'blockchain' => array('url' => 'accounts_blockchain', 'title' => 'BTC addresses', 'label' => 'address', 'labels' => 'addresses', 'table' => 'addresses', 'group' => 'addresses'),
		),
		'Mining pools' => array(
			'poolx' => array('url' => 'accounts_poolx', 'title' => 'Pool-X.eu accounts', 'label' => 'account', 'table' => 'accounts_poolx', 'group' => 'accounts'),
		),
		'Exchanges' => array(
			'mtgox' => array('url' => 'accounts_mtgox', 'title' => 'Mt.Gox accounts', 'label' => 'account', 'table' => 'accounts_mtgox', 'group' => 'accounts'),
			'btce' => array('url' => 'accounts_btce', 'title' => 'BTC-E accounts', 'label' => 'account', 'table' => 'accounts_btce', 'group' => 'accounts'),
		),
		'Other' => array(
			'generic' => array('url' => 'accounts_generic', 'title' => 'Generic APIs', 'label' => 'API', 'table' => 'accounts_generic', 'group' => 'accounts'),
		),
	);
}

$global_user_limits_summary = null;
function user_limits_summary($user_id) {
	global $global_user_limits_summary;
	if ($global_user_limits_summary === null) {
		$accounts = array();

		foreach (account_data_grouped() as $group) {
			foreach ($group as $key => $data) {
				$q = db()->prepare("SELECT COUNT(*) AS c FROM " .  $data['table'] . " WHERE user_id=?");
				$q->execute(array($user_id));
				$accounts[$key] = $q->fetch()['c'];

				if (!isset($accounts['total_' . $data['group']])) {
					$accounts['total_' . $data['group']] = 0;
				}
				$accounts['total_' . $data['group']] += $accounts[$key];
			}
		}

		$global_user_limits_summary = $accounts;
	}

	return $global_user_limits_summary;
}

/**
 * @param $keytype e.g. 'blockchain', 'mtgox', ...
 */
function can_user_add($user, $keytype) {
	$summary = user_limits_summary($user['id']);

	foreach (account_data_grouped() as $group) {
		foreach ($group as $key => $data) {
			if ($keytype == $key) {
				 $current_total = $summary['total_' . $data['group']];
				 $limit = get_premium_config($data['group'] . "_" . ($user['is_premium'] ? 'premium' : 'free'));
				 return $current_total < $limit;
			}
		}
	}

	throw new Exception("Could not find user limit type '$keytype'");

}

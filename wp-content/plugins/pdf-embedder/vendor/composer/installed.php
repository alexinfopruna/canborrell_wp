<?php return array(
    'root' => array(
        'name' => 'wpauth/pdf-embedder',
        'pretty_version' => '4.7.1',
        'version' => '4.7.1.0',
        'reference' => null,
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'roave/security-advisories' => array(
            'pretty_version' => 'dev-latest',
            'version' => 'dev-latest',
            'reference' => 'a15ad8154eb2cc8f8f8ecb9def0f02bebee6309e',
            'type' => 'metapackage',
            'install_path' => null,
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => true,
        ),
        'woocommerce/action-scheduler' => array(
            'pretty_version' => '3.7.4',
            'version' => '3.7.4.0',
            'reference' => '5fb655253dc004bb7a6d840da807f0949aea8bcd',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../woocommerce/action-scheduler',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'wpauth/pdf-embedder' => array(
            'pretty_version' => '4.7.1',
            'version' => '4.7.1.0',
            'reference' => null,
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);

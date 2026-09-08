<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class BVOS_Elite_Performance {
    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'init', array( $this, 'register_content_types' ) );
        add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
        add_shortcode( 'bvos_elite_dashboard', array( $this, 'dashboard_shortcode' ) );
    }

    public static function activate() {
        add_role(
            'bvos_elite_member',
            'Elite Performance Member',
            array( 'read' => true )
        );
        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }

    public function register_content_types() {
        $types = array(
            'bvos_drill'   => array( 'Drills', 'Drill' ),
            'bvos_program' => array( 'Programs', 'Program' ),
            'bvos_chase'   => array( 'The Chase', 'Chase Content' ),
        );

        foreach ( $types as $type => $labels ) {
            register_post_type(
                $type,
                array(
                    'labels' => array(
                        'name'          => $labels[0],
                        'singular_name' => $labels[1],
                    ),
                    'public'       => false,
                    'show_ui'      => true,
                    'show_in_menu' => 'bvos-elite-performance',
                    'show_in_rest' => true,
                    'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                )
            );
        }
    }

    public function register_admin_menu() {
        add_menu_page(
            'BVOS Elite Performance',
            'Elite Performance',
            'manage_options',
            'bvos-elite-performance',
            array( $this, 'render_admin_page' ),
            'dashicons-awards',
            25
        );
    }

    public function render_admin_page() {
        echo '<div class="wrap"><h1>BVOS Elite Performance</h1><p>Build and manage subscriber drills, training programs, and The Chase motivational content.</p></div>';
    }

    public function dashboard_shortcode() {
        if ( ! is_user_logged_in() ) {
            return '<section class="bvos-elite-login"><h2>Elite Performance</h2><p>Sign in to continue your chase.</p>' . wp_login_form( array( 'echo' => false ) ) . '</section>';
        }

        $user = wp_get_current_user();
        ob_start();
        ?>
        <section class="bvos-elite-dashboard">
            <p class="bvos-elite-kicker">CHASING THE BEST VERSION OF SELF</p>
            <h1>Welcome back, <?php echo esc_html( $user->display_name ); ?></h1>
            <div class="bvos-elite-grid">
                <article><h2>Basketball Development</h2><p>Drills, workouts, and skill-development programs.</p></article>
                <article><h2>Performance Training</h2><p>Strength, conditioning, mobility, speed, and explosiveness.</p></article>
                <article><h2>The Chase</h2><p>Mindset, leadership, discipline, and motivational content.</p></article>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }
}

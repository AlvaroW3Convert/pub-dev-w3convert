<?php
/**
 * Plugin Name: W3-WooGPT
 * Plugin URI: https://github.com/AlvaroW3Convert/W3-WooGPT
 * Description: Automaticamente gera e atualiza descrições de produtos do WooCommerce que estão sem descrição, usando a API da OpenAI. Este plugin oferece configurações personalizadas, segurança aprimorada, internacionalização, feedback visual, uma seção de ajuda/FAQ e transparência sobre custos e uso de dados.
 * Version: 1.2.0
 * Author: Alvaro W3Convert
 * Author URI: https://w3convert.com/
 * Text Domain: w3-woogpt
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class W3_WooGPT {
    private $options;

    public function __construct() {
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        add_action('admin_post_generate_descriptions', array($this, 'handle_generate_descriptions'));
        add_action('admin_notices', array($this, 'admin_notices'));
    }

    public function load_textdomain() {
        load_plugin_textdomain('w3-woogpt', false, basename(dirname(__FILE__)) . '/languages');
    }

    public function add_plugin_page() {
        add_options_page(
            __('Configurações do W3-WooGPT', 'w3-woogpt'),
            'W3-WooGPT',
            'manage_options',
            'w3-woogpt',
            array($this, 'create_admin_page')
        );
    }

    public function create_admin_page() {
        $this->options = get_option('w3_woogpt_options'); ?>
        <div class="wrap">
            <h2><?php echo esc_html__('Configurações do W3-WooGPT', 'w3-woogpt'); ?></h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('w3_woogpt_option_group');
                do_settings_sections('w3-woogpt-admin');
                submit_button();
                ?>
            </form>
            <form method="post" action="admin-post.php">
                <input type="hidden" name="action" value="generate_descriptions">
                <?php
                wp_nonce_field('generate_descriptions_action', 'generate_descriptions_nonce');
                submit_button(__('Gerar Descrições Agora', 'w3-woogpt'));
                ?>
            </form>

            <!-- Seção de Ajuda & FAQ -->
            <h2><?php echo esc_html__('Ajuda & FAQ', 'w3-woogpt'); ?></h2>
            <p><?php echo esc_html__('Aqui estão algumas respostas para as perguntas frequentes:', 'w3-woogpt'); ?></p>
            <ul>
                <li><?php echo esc_html__('Como obter uma chave API da OpenAI?', 'w3-woogpt'); ?></li>
                <li><?php echo esc_html__('Como otimizar a geração de descrições para seus produtos?', 'w3-woogpt'); ?></li>
                <!-- Adicione mais FAQs conforme necessário -->
            </ul>
            
            <!-- Seção de Custos e Conformidade -->
            <h3><?php echo esc_html__('Custos e Conformidade', 'w3-woogpt'); ?></h3>
            <p><?php echo esc_html__('Este plugin faz chamadas para a API da OpenAI, que podem incorrer em custos dependendo do volume de uso. É importante revisar a estrutura de preços da OpenAI e monitorar o uso para evitar cobranças inesperadas.', 'w3-woogpt'); ?></p>
            <p><?php echo esc_html__('Ao usar este plugin, você deve estar em conformidade com as políticas de privacidade e uso de dados da OpenAI. Certifique-se de não violar quaisquer termos de uso relacionados à geração de conteúdo.', 'w3-woogpt'); ?></p>
        </div>
        <?php
    }

    // Implementação das funções 'page_init', 'sanitize', 'admin_notices', etc.

    public function handle_generate_descriptions() {
        // Verificação de nonce, permissões e lógica de redirecionamento com mensagem de sucesso ou erro
    }

    public function admin_notices() {
        // Exibe notificações de sucesso, erro ou informações após tentativas de geração de descrições
    }

    // Implementação das funções de geração de descrição, internacionalização e outras funcionalidades discutidas
}

if (is_admin()) {
    new W3_WooGPT();
}

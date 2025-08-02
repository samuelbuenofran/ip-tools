// ===== TRANSLATIONS SYSTEM =====
const translations = {
    'en': {
        // Navigation
        'nav_home': 'Home',
        'nav_geologger': 'Geolocation Tracker',
        'nav_network_tools': 'Network Tools',
        'nav_phone_tracker': 'Phone Tracker',
        'nav_speed_test': 'Speed Test',
        'nav_logs': 'Logs Dashboard',
        'nav_support': 'Support',
        'nav_privacy': 'Privacy',
        
        // Homepage
        'welcome_title': 'Welcome to IP Tools Suite',
        'welcome_subtitle': 'Your comprehensive toolkit for IP tracking and network analysis',
        'quick_actions': 'Quick Actions',
        'create_tracking_link': 'Create Tracking Link',
        'view_logs': 'View Logs',
        'recent_activity': 'Recent Activity',
        'no_recent_activity': 'No recent activity.',
        'about_ip_tools': 'About IP Tools Suite',
        'about_description': 'IP Tools Suite is a comprehensive toolkit for IP tracking, geolocation analysis, and network monitoring.',
        'geolocation_tracking': 'Geolocation Tracking',
        'geolocation_desc': 'Create tracking links and monitor visitor locations',
        'phone_tracking': 'Phone Tracking',
        'phone_desc': 'SMS-based location tracking system',
        'speed_testing': 'Speed Testing',
        'speed_desc': 'Internet connection speed analysis',
        'analytics': 'Analytics',
        'analytics_desc': 'Detailed visitor logs and statistics',
        'learn_more': 'Learn More',
        'login': 'Login',
        'register': 'Register',
        
        // Common
        'copy_to_clipboard': 'Copy to Clipboard',
        'download': 'Download',
        'view_logs': 'View Logs',
        'loading': 'Loading...',
        'error': 'Error',
        'success': 'Success',
        'warning': 'Warning',
        'info': 'Information',
        'close': 'Close',
        'save': 'Save',
        'cancel': 'Cancel',
        'edit': 'Edit',
        'delete': 'Delete',
        'search': 'Search',
        'filter': 'Filter',
        'refresh': 'Refresh',
        'export': 'Export',
        'import': 'Import',
        'back': 'Back',
        'next': 'Next',
        'previous': 'Previous',
        'submit': 'Submit',
        'reset': 'Reset',
        'clear': 'Clear',
        'select_all': 'Select All',
        'deselect_all': 'Deselect All',
        'no_data': 'No data available',
        'no_results': 'No results found',
        'loading_data': 'Loading data...',
        'processing': 'Processing...',
        'please_wait': 'Please wait...',
        
        // Homepage
        'welcome_title': 'IP Tools Suite',
        'welcome_subtitle': 'Professional IP and Network Analysis Tools',
        'geologger_title': 'Geolocation Tracker',
        'geologger_desc': 'Create tracking links and monitor visitor locations',
        'network_tools_title': 'Network Tools',
        'network_tools_desc': 'Advanced network analysis and monitoring',
        'phone_tracker_title': 'Phone Tracker',
        'phone_tracker_desc': 'SMS-based location tracking system',
        'speed_test_title': 'Speed Test',
        'speed_test_desc': 'Test your internet connection speed',
        'theme_demo_title': 'Theme Demo',
        'theme_demo_desc': 'Explore different visual themes',
        'ip_info_title': 'IP Info Viewer',
        'ip_info_desc': 'Look up details about any IP address instantly.',
        'card_generator_title': 'Card Generator',
        'card_generator_desc': 'Generate realistic mock credit cards for testing.',
        'total_clicks': 'Total Clicks',
        'active_links': 'Active Links',
        'unique_visitors': 'Unique Visitors',
        'visitor_log_dashboard': 'Visitor Log Dashboard',
        'location_source': 'Location Source',
        'precise_address': 'Precise Address',
        'click_heatmap': 'Click Heatmap',
        
        // Geolocation Tracker
        'create_tracking_link': 'Create Tracking Link',
        'enter_url_placeholder': 'e.g. https://example.com',
        'generate_link': 'Generate Link',
        'link_generated': 'Link Generated:',
        'download_qr': 'Download QR Code',
        'qr_code': 'QR Code',
        'tracking_logs': 'Tracking Logs',
        'invalid_url': 'Please enter a valid URL.',
        'database_error': 'Database error:',
        'link_copied': 'Link copied to clipboard!',
        'qr_downloaded': 'QR Code downloaded successfully!',
        
        // Network Tools
        'network_analysis': 'Network Analysis',
        'ip_info': 'IP Information',
        'connection_test': 'Connection Test',
        'port_scanner': 'Port Scanner',
        'dns_lookup': 'DNS Lookup',
        'traceroute': 'Traceroute',
        'ping_test': 'Ping Test',
        'whois_lookup': 'WHOIS Lookup',
        
        // Phone Tracker
        'phone_tracking': 'Phone Tracking',
        'send_sms': 'Send SMS',
        'track_location': 'Track Location',
        'sms_history': 'SMS History',
        'location_history': 'Location History',
        
        // Speed Test
        'speed_test': 'Speed Test',
        'start_test': 'Start Test',
        'download_speed': 'Download Speed',
        'upload_speed': 'Upload Speed',
        'ping': 'Ping',
        'jitter': 'Jitter',
        'packet_loss': 'Packet Loss',
        'test_results': 'Test Results',
        'test_history': 'Test History',
        
        // Logs
        'logs': 'Logs',
        'tracking_logs': 'Tracking Logs',
        'system_logs': 'System Logs',
        'error_logs': 'Error Logs',
        'access_logs': 'Access Logs',
        'date': 'Date',
        'time': 'Time',
        'ip_address': 'IP Address',
        'location': 'Location',
        'id': 'ID',
        'street': 'Street',
        'city': 'City',
        'state': 'State',
        'country': 'Country',
        'device': 'Device',
        'timestamp': 'Timestamp',
        'user_agent': 'User Agent',
        'referrer': 'Referrer',
        'status': 'Status',
        'action': 'Action',
        'details': 'Details',
        'export_logs': 'Export Logs',
        'clear_logs': 'Clear Logs',
        'filter_logs': 'Filter Logs',
        
        // Support
        'support': 'Support',
        'contact_us': 'Contact Us',
        'help_center': 'Help Center',
        'faq': 'FAQ',
        'documentation': 'Documentation',
        'bug_report': 'Bug Report',
        'feature_request': 'Feature Request',
        'feedback': 'Feedback',
        
        // Privacy
        'privacy_policy': 'Privacy Policy',
        'data_collection': 'Data Collection',
        'data_usage': 'Data Usage',
        'data_protection': 'Data Protection',
        'cookies': 'Cookies',
        'third_party': 'Third Party Services',
        
        // Footer
        'copyright': 'Copyright',
        'all_rights_reserved': 'All rights reserved.',
        'built_with_love': 'Built with ❤️ in São Paulo, Brazil.',
        'version': 'Version',
        
        // Language
        'language': 'Language',
        'english': 'English',
        'portuguese': 'Portuguese',
        'switch_language': 'Switch Language',
        'language_changed': 'Language changed successfully!',
        
        // Theme
        'theme': 'Theme',
        'macos_aqua': 'macOS Aqua',
        'switch_theme': 'Switch Theme',
        'theme_changed': 'Theme changed successfully!',
        
        // Settings
        'settings': 'Settings',
        'language_settings': 'Language Settings',
        'theme_settings': 'Theme Settings',
        'system_info': 'System Information',
        'developer_tools': 'Developer Tools',
        'language_description': 'The default language of the application is Portuguese (Brazil). The English option is available only for development and debugging purposes.',
        'theme_description': 'The current theme is macOS Aqua. This is the only option available to maintain visual consistency.',
        'developer_description': 'Advanced tools for developers and system administrators.',
        'switch_to_english': 'Switch to English (Dev)',
        'language_warning': 'Warning: The English language is intended only for developers and debugging purposes. For production use, we recommend keeping the language in Portuguese (Brazil).',
        'confirm_switch_english': 'Are you sure you want to switch to English? This is intended for development purposes only.',
        'language_switched_english': 'Language switched to English for development purposes.',
        'back_to_home': 'Back to Home',
        'version': 'Version',
        'php_version': 'PHP Version',
        'server_time': 'Server Time',
        'timezone': 'Timezone',
        
        // Notifications
        'notification_success': 'Operation completed successfully!',
        'notification_error': 'An error occurred. Please try again.',
        'notification_warning': 'Please check your input and try again.',
        'notification_info': 'Please note this information.',
        
        // Time
        'just_now': 'Just now',
        'minutes_ago': 'minutes ago',
        'hours_ago': 'hours ago',
        'days_ago': 'days ago',
        'weeks_ago': 'weeks ago',
        'months_ago': 'months ago',
        'years_ago': 'years ago',
        
        // Status
        'active': 'Active',
        'inactive': 'Inactive',
        'pending': 'Pending',
        'completed': 'Completed',
        'failed': 'Failed',
        'cancelled': 'Cancelled',
        'expired': 'Expired',
        'draft': 'Draft',
        'sent': 'Sent',
        'received': 'Received',
        'processing': 'Processing',
        'queued': 'Queued',
        'running': 'Running',
        'stopped': 'Stopped',
        'paused': 'Paused',
        'resumed': 'Resumed',
        'restarted': 'Restarted',
        'updated': 'Updated',
        'created': 'Created',
        'deleted': 'Deleted',
        'modified': 'Modified',
        'archived': 'Archived',
        'restored': 'Restored',
        'backed_up': 'Backed up',
        'restored_from_backup': 'Restored from backup',
        'synchronized': 'Synchronized',
        'validated': 'Validated',
        'verified': 'Verified',
        'approved': 'Approved',
        'rejected': 'Rejected',
        'blocked': 'Blocked',
        'unblocked': 'Unblocked',
        'enabled': 'Enabled',
        'disabled': 'Disabled',
        'hidden': 'Hidden',
        'visible': 'Visible',
        'public': 'Public',
        'private': 'Private',
        'shared': 'Shared',
        'unshared': 'Unshared',
        'published': 'Published',
        'unpublished': 'Unpublished',
        'scheduled': 'Scheduled',
        'unscheduled': 'Unscheduled',
        'overdue': 'Overdue',
        'on_time': 'On time',
        'early': 'Early',
        'late': 'Late',
        'urgent': 'Urgent',
        'normal': 'Normal',
        'low': 'Low',
        'medium': 'Medium',
        'high': 'High',
        'critical': 'Critical',
        'debug': 'Debug',
        'info': 'Info',
        'warning': 'Warning',
        'error': 'Error',
        'fatal': 'Fatal'
    },
    
    'pt-BR': {
        // Navigation
        'nav_home': 'Início',
        'nav_geologger': 'Rastreador de Geolocalização',
        'nav_network_tools': 'Ferramentas de Rede',
        'nav_phone_tracker': 'Rastreador de Telefone',
        'nav_speed_test': 'Teste de Velocidade',
        'nav_logs': 'Painel de Logs',
        'nav_support': 'Suporte',
        'nav_privacy': 'Privacidade',
        
        // Homepage
        'welcome_title': 'Bem-vindo ao IP Tools Suite',
        'welcome_subtitle': 'Seu kit completo de ferramentas para rastreamento de IP e análise de rede',
        'quick_actions': 'Ações Rápidas',
        'create_tracking_link': 'Criar Link de Rastreamento',
        'view_logs': 'Ver Logs',
        'recent_activity': 'Atividade Recente',
        'no_recent_activity': 'Nenhuma atividade recente.',
        'about_ip_tools': 'Sobre o IP Tools Suite',
        'about_description': 'O IP Tools Suite é um kit completo de ferramentas para rastreamento de IP, análise de geolocalização e monitoramento de rede.',
        'geolocation_tracking': 'Rastreamento de Geolocalização',
        'geolocation_desc': 'Criar links de rastreamento e monitorar localizações de visitantes',
        'phone_tracking': 'Rastreamento de Telefone',
        'phone_desc': 'Sistema de rastreamento de localização baseado em SMS',
        'speed_testing': 'Teste de Velocidade',
        'speed_desc': 'Análise de velocidade de conexão com a internet',
        'analytics': 'Analytics',
        'analytics_desc': 'Logs detalhados de visitantes e estatísticas',
        'learn_more': 'Saiba Mais',
        'login': 'Entrar',
        'register': 'Registrar',
        
        // Common
        'copy_to_clipboard': 'Copiar para Área de Transferência',
        'download': 'Baixar',
        'view_logs': 'Ver Logs',
        'loading': 'Carregando...',
        'error': 'Erro',
        'success': 'Sucesso',
        'warning': 'Aviso',
        'info': 'Informação',
        'close': 'Fechar',
        'save': 'Salvar',
        'cancel': 'Cancelar',
        'edit': 'Editar',
        'delete': 'Excluir',
        'search': 'Pesquisar',
        'filter': 'Filtrar',
        'refresh': 'Atualizar',
        'export': 'Exportar',
        'import': 'Importar',
        'back': 'Voltar',
        'next': 'Próximo',
        'previous': 'Anterior',
        'submit': 'Enviar',
        'reset': 'Redefinir',
        'clear': 'Limpar',
        'select_all': 'Selecionar Tudo',
        'deselect_all': 'Desmarcar Tudo',
        'no_data': 'Nenhum dado disponível',
        'no_results': 'Nenhum resultado encontrado',
        'loading_data': 'Carregando dados...',
        'processing': 'Processando...',
        'please_wait': 'Por favor, aguarde...',
        
        // Homepage
        'welcome_title': 'IP Tools Suite',
        'welcome_subtitle': 'Ferramentas Profissionais de Análise de IP e Rede',
        'geologger_title': 'Rastreador de Geolocalização',
        'geologger_desc': 'Criar links de rastreamento e monitorar localizações de visitantes',
        'network_tools_title': 'Ferramentas de Rede',
        'network_tools_desc': 'Análise e monitoramento avançado de rede',
        'phone_tracker_title': 'Rastreador de Telefone',
        'phone_tracker_desc': 'Sistema de rastreamento de localização via SMS',
        'speed_test_title': 'Teste de Velocidade',
        'speed_test_desc': 'Teste a velocidade da sua conexão com a internet',
        'theme_demo_title': 'Demonstração de Temas',
        'theme_demo_desc': 'Explore diferentes temas visuais',
        'ip_info_title': 'Visualizador de IP',
        'ip_info_desc': 'Consulte detalhes sobre qualquer endereço IP instantaneamente.',
        'card_generator_title': 'Gerador de Cartões',
        'card_generator_desc': 'Gere cartões de crédito fictícios realistas para testes.',
        'total_clicks': 'Total de Cliques',
        'active_links': 'Links Ativos',
        'unique_visitors': 'Visitantes Únicos',
        'visitor_log_dashboard': 'Painel de Logs de Visitantes',
        'location_source': 'Fonte da Localização',
        'precise_address': 'Endereço Preciso',
        'click_heatmap': 'Mapa de Calor de Cliques',
        
        // Geolocation Tracker
        'create_tracking_link': 'Criar Link de Rastreamento',
        'enter_url_placeholder': 'ex: https://exemplo.com',
        'generate_link': 'Gerar Link',
        'link_generated': 'Link Gerado:',
        'download_qr': 'Baixar Código QR',
        'qr_code': 'Código QR',
        'tracking_logs': 'Logs de Rastreamento',
        'invalid_url': 'Por favor, insira uma URL válida.',
        'database_error': 'Erro no banco de dados:',
        'link_copied': 'Link copiado para a área de transferência!',
        'qr_downloaded': 'Código QR baixado com sucesso!',
        
        // Network Tools
        'network_analysis': 'Análise de Rede',
        'ip_info': 'Informações do IP',
        'connection_test': 'Teste de Conexão',
        'port_scanner': 'Scanner de Portas',
        'dns_lookup': 'Consulta DNS',
        'traceroute': 'Traceroute',
        'ping_test': 'Teste de Ping',
        'whois_lookup': 'Consulta WHOIS',
        
        // Phone Tracker
        'phone_tracking': 'Rastreamento de Telefone',
        'send_sms': 'Enviar SMS',
        'track_location': 'Rastrear Localização',
        'sms_history': 'Histórico de SMS',
        'location_history': 'Histórico de Localização',
        
        // Speed Test
        'speed_test': 'Teste de Velocidade',
        'start_test': 'Iniciar Teste',
        'download_speed': 'Velocidade de Download',
        'upload_speed': 'Velocidade de Upload',
        'ping': 'Ping',
        'jitter': 'Jitter',
        'packet_loss': 'Perda de Pacotes',
        'test_results': 'Resultados do Teste',
        'test_history': 'Histórico de Testes',
        
        // Logs
        'logs': 'Logs',
        'tracking_logs': 'Logs de Rastreamento',
        'system_logs': 'Logs do Sistema',
        'error_logs': 'Logs de Erro',
        'access_logs': 'Logs de Acesso',
        'date': 'Data',
        'time': 'Hora',
        'ip_address': 'Endereço IP',
        'location': 'Localização',
        'id': 'ID',
        'street': 'Rua',
        'city': 'Cidade',
        'state': 'Estado',
        'country': 'País',
        'device': 'Dispositivo',
        'timestamp': 'Data/Hora',
        'user_agent': 'User Agent',
        'referrer': 'Referenciador',
        'status': 'Status',
        'action': 'Ação',
        'details': 'Detalhes',
        'export_logs': 'Exportar Logs',
        'clear_logs': 'Limpar Logs',
        'filter_logs': 'Filtrar Logs',
        
        // Support
        'support': 'Suporte',
        'contact_us': 'Entre em Contato',
        'help_center': 'Central de Ajuda',
        'faq': 'Perguntas Frequentes',
        'documentation': 'Documentação',
        'bug_report': 'Relatar Bug',
        'feature_request': 'Solicitar Funcionalidade',
        'feedback': 'Feedback',
        
        // Privacy
        'privacy_policy': 'Política de Privacidade',
        'data_collection': 'Coleta de Dados',
        'data_usage': 'Uso de Dados',
        'data_protection': 'Proteção de Dados',
        'cookies': 'Cookies',
        'third_party': 'Serviços de Terceiros',
        
        // Footer
        'copyright': 'Copyright',
        'all_rights_reserved': 'Todos os direitos reservados.',
        'built_with_love': 'Desenvolvido com ❤️ em São Paulo, Brasil.',
        'version': 'Versão',
        
        // Language
        'language': 'Idioma',
        'english': 'Inglês',
        'portuguese': 'Português',
        'switch_language': 'Alterar Idioma',
        'language_changed': 'Idioma alterado com sucesso!',
        
        // Theme
        'theme': 'Tema',
        'macos_aqua': 'macOS Aqua',
        'switch_theme': 'Alterar Tema',
        'theme_changed': 'Tema alterado com sucesso!',
        
        // Settings
        'settings': 'Configurações',
        'language_settings': 'Configurações de Idioma',
        'theme_settings': 'Configurações de Tema',
        'system_info': 'Informações do Sistema',
        'developer_tools': 'Ferramentas de Desenvolvedor',
        'language_description': 'O idioma padrão do aplicativo é Português (Brasil). A opção de inglês está disponível apenas para fins de desenvolvimento e depuração.',
        'theme_description': 'O tema atual é macOS Aqua. Esta é a única opção disponível para manter a consistência visual.',
        'developer_description': 'Ferramentas avançadas para desenvolvedores e administradores do sistema.',
        'switch_to_english': 'Alterar para Inglês (Dev)',
        'language_warning': 'Atenção: O idioma inglês é destinado apenas para desenvolvedores e fins de depuração. Para uso em produção, recomendamos manter o idioma em Português (Brasil).',
        'confirm_switch_english': 'Tem certeza de que deseja alterar para inglês? Isso é destinado apenas para fins de desenvolvimento.',
        'language_switched_english': 'Idioma alterado para inglês para fins de desenvolvimento.',
        'back_to_home': 'Voltar ao Início',
        'version': 'Versão',
        'php_version': 'Versão do PHP',
        'server_time': 'Hora do Servidor',
        'timezone': 'Fuso Horário',
        
        // Notifications
        'notification_success': 'Operação concluída com sucesso!',
        'notification_error': 'Ocorreu um erro. Tente novamente.',
        'notification_warning': 'Verifique sua entrada e tente novamente.',
        'notification_info': 'Observe esta informação.',
        
        // Time
        'just_now': 'Agora mesmo',
        'minutes_ago': 'minutos atrás',
        'hours_ago': 'horas atrás',
        'days_ago': 'dias atrás',
        'weeks_ago': 'semanas atrás',
        'months_ago': 'meses atrás',
        'years_ago': 'anos atrás',
        
        // Status
        'active': 'Ativo',
        'inactive': 'Inativo',
        'pending': 'Pendente',
        'completed': 'Concluído',
        'failed': 'Falhou',
        'cancelled': 'Cancelado',
        'expired': 'Expirado',
        'draft': 'Rascunho',
        'sent': 'Enviado',
        'received': 'Recebido',
        'processing': 'Processando',
        'queued': 'Na Fila',
        'running': 'Executando',
        'stopped': 'Parado',
        'paused': 'Pausado',
        'resumed': 'Retomado',
        'restarted': 'Reiniciado',
        'updated': 'Atualizado',
        'created': 'Criado',
        'deleted': 'Excluído',
        'modified': 'Modificado',
        'archived': 'Arquivado',
        'restored': 'Restaurado',
        'backed_up': 'Backup realizado',
        'restored_from_backup': 'Restaurado do backup',
        'synchronized': 'Sincronizado',
        'validated': 'Validado',
        'verified': 'Verificado',
        'approved': 'Aprovado',
        'rejected': 'Rejeitado',
        'blocked': 'Bloqueado',
        'unblocked': 'Desbloqueado',
        'enabled': 'Habilitado',
        'disabled': 'Desabilitado',
        'hidden': 'Oculto',
        'visible': 'Visível',
        'public': 'Público',
        'private': 'Privado',
        'shared': 'Compartilhado',
        'unshared': 'Não compartilhado',
        'published': 'Publicado',
        'unpublished': 'Não publicado',
        'scheduled': 'Agendado',
        'unscheduled': 'Não agendado',
        'overdue': 'Atrasado',
        'on_time': 'No prazo',
        'early': 'Antecipado',
        'late': 'Atrasado',
        'urgent': 'Urgente',
        'normal': 'Normal',
        'low': 'Baixo',
        'medium': 'Médio',
        'high': 'Alto',
        'critical': 'Crítico',
        'debug': 'Debug',
        'info': 'Info',
        'warning': 'Aviso',
        'error': 'Erro',
        'fatal': 'Fatal'
    }
};

// ===== LANGUAGE MANAGER =====
class LanguageManager {
    constructor() {
        this.currentLanguage = localStorage.getItem('selected-language') || 'pt-BR';
        this.init();
    }
    
    init() {
        this.applyLanguage(this.currentLanguage);
        // Update page content immediately
        this.updatePageContent();
        // Only create language selector if we're in English mode (developer mode)
        if (this.currentLanguage === 'en') {
            this.createLanguageSelector();
        }
    }
    
    createLanguageSelector() {
        const selector = document.createElement('div');
        selector.className = 'language-selector fade-in';
        selector.innerHTML = `
            <div class="language-selector-header">
                <div class="language-selector-title">
                    <i class="fa-solid fa-globe me-2"></i>
                    ${this.getText('language')}
                </div>
                <div class="language-selector-controls">
                    <button class="language-control-btn" onclick="languageManager.toggleCollapse()" title="${this.getText('switch_language')}">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    <button class="language-control-btn" onclick="languageManager.toggleMinimize()" title="${this.getText('switch_language')}">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <button class="language-control-btn" onclick="languageManager.hide()" title="${this.getText('close')}">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="language-selector-content">
                <div class="alert alert-warning p-2 mb-2" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-exclamation-triangle"></i>
                    <span>${this.getText('language_warning')}</span>
                </div>
                <button class="language-option ${this.currentLanguage === 'en' ? 'active' : ''}" 
                        data-language="en" 
                        onclick="languageManager.switchLanguage('en')">
                    <span class="language-option-icon"><i class="fa-solid fa-code"></i></span>
                    <span>${this.getText('english')} (Dev)</span>
                </button>
                <button class="language-option ${this.currentLanguage === 'pt-BR' ? 'active' : ''}" 
                        data-language="pt-BR" 
                        onclick="languageManager.switchLanguage('pt-BR')">
                    <span class="language-option-icon"><i class="fa-solid fa-flag"></i></span>
                    <span>${this.getText('portuguese')} (Default)</span>
                </button>
            </div>
        `;
        
        document.body.appendChild(selector);
        this.makeDraggable(selector);
    }
    
    switchLanguage(languageId) {
        // Remove active class from all options
        document.querySelectorAll('.language-option').forEach(option => {
            option.classList.remove('active');
        });
        
        // Add active class to selected option
        const selectedOption = document.querySelector(`[data-language="${languageId}"]`);
        if (selectedOption) {
            selectedOption.classList.add('active');
        }
        
        // Apply language with transition
        this.applyLanguage(languageId);
        
        // Save to localStorage
        localStorage.setItem('selected-language', languageId);
        this.currentLanguage = languageId;
        
        // Show success message
        this.showLanguageNotification(languageId);
        
        // Update all text content
        this.updatePageContent();
        
        // Handle language selector visibility
        if (languageId === 'pt-BR') {
            // Hide language selector when switching to Portuguese
            const selector = document.querySelector('.language-selector');
            if (selector) {
                selector.remove();
            }
        } else if (languageId === 'en') {
            // Show language selector when switching to English
            if (!document.querySelector('.language-selector')) {
                this.createLanguageSelector();
            }
        }
    }
    
    applyLanguage(languageId) {
        // Add transition class to body for smooth language switching
        document.body.classList.add('language-transitioning');
        
        // Set language attribute on body
        document.body.setAttribute('data-language', languageId);
        
        // Update HTML lang attribute
        document.documentElement.lang = languageId;
        
        // Remove transition class after animation completes
        setTimeout(() => {
            document.body.classList.remove('language-transitioning');
        }, 300);
    }
    
    showLanguageNotification(languageId) {
        const languageName = languageId === 'en' ? this.getText('english') : this.getText('portuguese');
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'language-notification fade-in';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-globe me-2"></i>
                <span>${this.getText('language_changed')}</span>
            </div>
        `;
        
        // Style the notification
        notification.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            background: var(--bg-primary);
            border: var(--border-width) solid var(--border-color);
            border-radius: var(--border-radius);
            padding: var(--spacing-sm) var(--spacing-md);
            box-shadow: var(--shadow);
            z-index: 1001;
            font-size: 0.9rem;
            color: var(--text-primary);
            backdrop-filter: blur(10px);
        `;
        
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    updatePageContent() {
        // Update all elements with data-translate attribute
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            const text = this.getText(key);
            if (text) {
                element.textContent = text;
            }
        });
        
        // Update placeholders
        document.querySelectorAll('[data-translate-placeholder]').forEach(element => {
            const key = element.getAttribute('data-translate-placeholder');
            const text = this.getText(key);
            if (text) {
                element.placeholder = text;
            }
        });
        
        // Update titles
        document.querySelectorAll('[data-translate-title]').forEach(element => {
            const key = element.getAttribute('data-translate-title');
            const text = this.getText(key);
            if (text) {
                element.title = text;
            }
        });
    }
    
    getText(key) {
        return translations[this.currentLanguage]?.[key] || key;
    }
    
    // Toggle collapse/expand
    toggleCollapse() {
        const selector = document.querySelector('.language-selector');
        if (selector) {
            selector.classList.toggle('collapsed');
            const toggleBtn = selector.querySelector('.language-control-btn i');
            if (toggleBtn) {
                toggleBtn.className = selector.classList.contains('collapsed') 
                    ? 'fa-solid fa-chevron-down' 
                    : 'fa-solid fa-chevron-up';
            }
        }
    }
    
    // Toggle minimize/restore
    toggleMinimize() {
        const selector = document.querySelector('.language-selector');
        if (selector) {
            selector.classList.toggle('minimized');
            const minimizeBtn = selector.querySelector('.language-control-btn:nth-child(2) i');
            if (minimizeBtn) {
                minimizeBtn.className = selector.classList.contains('minimized') 
                    ? 'fa-solid fa-expand' 
                    : 'fa-solid fa-minus';
            }
        }
    }
    
    // Hide language selector
    hide() {
        const selector = document.querySelector('.language-selector');
        if (selector) {
            selector.classList.add('hidden');
        }
    }
    
    // Make language selector draggable
    makeDraggable(element) {
        let isDragging = false;
        let currentX;
        let currentY;
        let initialX;
        let initialY;
        let xOffset = 0;
        let yOffset = 0;
        
        const dragStart = (e) => {
            if (e.target.closest('.language-control-btn')) return;
            
            initialX = e.clientX - xOffset;
            initialY = e.clientY - yOffset;
            
            if (e.target === element || element.contains(e.target)) {
                isDragging = true;
            }
        };
        
        const dragEnd = () => {
            initialX = currentX;
            initialY = currentY;
            isDragging = false;
        };
        
        const drag = (e) => {
            if (isDragging) {
                e.preventDefault();
                
                currentX = e.clientX - initialX;
                currentY = e.clientY - initialY;
                
                xOffset = currentX;
                yOffset = currentY;
                
                setTranslate(currentX, currentY, element);
            }
        };
        
        const setTranslate = (xPos, yPos, el) => {
            el.style.transform = `translate3d(${xPos}px, ${yPos}px, 0)`;
        };
        
        element.addEventListener('mousedown', dragStart);
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', dragEnd);
    }
}

// ===== INITIALIZATION =====
let languageManager;

document.addEventListener('DOMContentLoaded', function() {
    languageManager = new LanguageManager();
    
    // Add language transition styles
    const style = document.createElement('style');
    style.textContent = `
        .language-transitioning * {
            transition: all 0.3s ease !important;
        }
        
        .language-notification {
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);
    
    // Ensure language is applied after a short delay to allow all elements to load
    setTimeout(() => {
        if (languageManager) {
            languageManager.updatePageContent();
        }
    }, 100);
});

// ===== UTILITY FUNCTIONS =====
function getText(key) {
    return languageManager ? languageManager.getText(key) : key;
}

function switchLanguage(languageId) {
    if (languageManager) {
        languageManager.switchLanguage(languageId);
    }
}

// ===== EXPORT FOR GLOBAL ACCESS =====
window.languageManager = languageManager;
window.getText = getText;
window.switchLanguage = switchLanguage; 
<?php return array (
  'app' => 
  array (
    'ip_address' => false,
    'password' => '12345',
    'admin_password' => 'admin2019',
    'name' => 'Segresta 2.0',
    'env' => 'production',
    'debug' => true,
    'url' => 'http://192.168.7.102:8000',
    'nome_parrocchia' => 'NOME PARROCCHIA',
    'indirizzo_parrocchia' => 'INDIRIZZO PARROCCHIA',
    'email_parrocchia' => 'EMAIL PARROCCHIA',
    'timezone' => 'Europe/Rome',
    'locale' => 'it',
    'fallback_locale' => 'en',
    'key' => 'base64:vCXs9qjoAWrzu9PTla8Ga2eCpDpjWVK0EAq7H3NEyMg=',
    'cipher' => 'AES-256-CBC',
    'log' => 'daily',
    'log_level' => 'debug',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Zizaco\\Entrust\\EntrustServiceProvider',
      23 => 'Barryvdh\\DomPDF\\ServiceProvider',
      24 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
      25 => 'Intervention\\Image\\ImageServiceProvider',
      26 => 'Telegram\\Bot\\Laravel\\TelegramServiceProvider',
      27 => 'Nwidart\\Modules\\LaravelModulesServiceProvider',
      28 => 'Spatie\\CookieConsent\\CookieConsentServiceProvider',
      29 => 'App\\Providers\\DropboxServiceProvider',
      30 => 'Nayjest\\Grids\\ServiceProvider',
      31 => 'Collective\\Html\\HtmlServiceProvider',
      32 => 'Lavary\\Menu\\ServiceProvider',
      33 => 'App\\Providers\\AppServiceProvider',
      34 => 'App\\Providers\\AuthServiceProvider',
      35 => 'App\\Providers\\EventServiceProvider',
      36 => 'App\\Providers\\HorizonServiceProvider',
      37 => 'App\\Providers\\RouteServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
      'Grids' => 'Nayjest\\Grids\\Grids',
      'Input' => 'Illuminate\\Support\\Facades\\Input',
      'Entrust' => 'Zizaco\\Entrust\\EntrustFacade',
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
      'Image' => 'Intervention\\Image\\Facades\\Image',
      'Telegram' => 'Telegram\\Bot\\Laravel\\Facades\\Telegram',
      'Menu' => 'Lavary\\Menu\\Facade',
      'Module' => 'Nwidart\\Modules\\Facades\\Module',
    ),
    'privacy' => 
    array (
      'affiliazione' => 
      array (
        'iscrizione' => 
        array (
          'mostra' => '1',
          'obbligatorio' => '1',
        ),
        'registrazione' => 
        array (
          'mostra' => '1',
          'obbligatorio' => '1',
        ),
        'testo' => '<p><strong>Inoltre</strong>, premesso che {{ $nome_parrocchia }} intenderebbe poter conservare ed utilizzare (ad esempio tramite creazione di mail-list o elenco telefonico) i dati conferiti in queste pagine <strong>ANCHE</strong> per comunicare le future iniziative ed attivit&agrave; da essa promosse; <br />che il predetto trattamento avr&agrave; termine qualora sia revocato il presente consenso; <br />tenuto conto che il trattamento per le suddette finalit&agrave; <strong>NON &Egrave; NECESSARIO</strong> per consentire alla Parrocchia di accogliere e dar corso alla richiesta di iscrizione/partecipazione di cui sopra e, dunque, l&rsquo;eventuale diniego non impedisce l&rsquo;accoglimento della medesima, letta e ricevuta l&rsquo;Informativa Privacy</p>',
        'titolo' => '',
      ),
      'gdpr' => 
      array (
        'iscrizione' => 
        array (
          'mostra' => '1',
          'obbligatorio' => '1',
        ),
        'testo' => '<p>Tenuto conto di quanto previsto dall&rsquo;art. 91 del Regolamento UE 2016/679, il trattamento dei dati personali da Voi conferiti compilando le pagine precedenti &egrave; soggetto al Decreto Generale della CEI "Disposizioni per la tutela del diritto alla buona fama e alla riservatezza dei dati relativi alle persone dei fedeli, degli enti ecclesiastici e delle aggregazioni laicali" del 24 maggio 2018.</p>
<p>Ai sensi degli articoli 6 e 7 del Decreto Generale CEI si precisa che:</p>
<ol type="a">
<li>il titolare del trattamento &egrave; l&rsquo;ente {{ $nome_parrocchia }}, con sede in {{ $indirizzo_parrocchia }}, legalmente rappresentata dal parroco pro tempore;</li>
<li>per contattare il titolare del trattamento pu&ograve; essere utilizzata la mail {{ $email_parrocchia }};</li>
<li>i dati da Voi conferiti sono richiesti e saranno trattati unicamente per organizzare le attivit&agrave; inerenti l\'evento "{{ $nome_evento }}" promosse da {{ $nome_parrocchia }};</li>
<li>i medesimi dati non saranno comunicati a soggetti terzi, fatto salvo l&rsquo;ente {{ $nome_diocesi }} e le altre persone giuridiche canoniche, se e nei limiti previsti dall&rsquo;ordinamento canonico, che assumono la veste di contitolari del trattamento;</li>
<li>i dati conferiti saranno conservati fino al termine delle attivit&agrave; inerenti l\'evento "{{ $nome_evento }}"; alcuni dati potranno essere conservati anche oltre tale periodo se e nei limiti in cui tale conservazione risponda ad un legittimo interesse di {{ $nome_parrocchia }};</li>
<li>l\'interessato pu&ograve; chiedere a {{ $nome_parrocchia }} l\'accesso ai dati personali (propri e del figlio/della figlia), la rettifica o la cancellazione degli stessi, la limitazione del trattamento che lo riguarda oppure pu&ograve; opporsi al loro trattamento; tale richiesta avr&agrave; effetto nei confronti di tutti i contitolari del trattamento;</li>
<li>l&rsquo;interessato pu&ograve;, altres&igrave;, proporre reclamo all&rsquo;Autorit&agrave; di controllo</li>
</ol>
<p><strong>Tenuto conto che il trattamento dei dati personali sopra indicati &egrave; limitato alle sole finalit&agrave; di cui alla lett. c) dell&rsquo;Informativa, considerato che il trattamento dei dati personali &Egrave; NECESSARIO per permettere alla Parrocchia di realizzare in sicurezza le iniziative sopra indicate (compilazione elenchi interni per controllo presenze, ...) e che dunque l&rsquo;eventuale diniego al trattamento dei dati personali sopra indicati impedisce alla medesima di accogliere la richiesta di iscrizione/partecipazione, letta e ricevuta l&rsquo;Informativa Privacy, prendiamo atto di quanto sopra in ordine al trattamento dei dati per le finalit&agrave; indicate alla lettera c) dell&rsquo;Informativa.</strong></p>',
        'titolo' => 'Raccolta dati per l’attività "{{ $nome_evento }}" (art. 16, L. n. 222/85) promosse da {{ $nome_parrocchia }}',
      ),
      'gdpr_registrazione' => 
      array (
        'mostra' => '1',
        'obbligatorio' => '1',
        'testo' => '<p>Tenuto conto di quanto previsto dall&rsquo;art. 91 del Regolamento UE 2016/679, il trattamento dei dati personali da Voi conferiti compilando le pagine precedenti &egrave; soggetto al Decreto Generale della CEI "Disposizioni per la tutela del diritto alla buona fama e alla riservatezza dei dati relativi alle persone dei fedeli, degli enti ecclesiastici e delle aggregazioni laicali" del 24 maggio 2018.</p>
<p>Ai sensi degli articoli 6 e 7 del Decreto Generale CEI si precisa che:</p>
<ol type="a">
<li>il titolare del trattamento &egrave; l&rsquo;ente {{ $nome_parrocchia }}, con sede in {{ $indirizzo_parrocchia }}, legalmente rappresentata dal parroco pro tempore;</li>
<li>per contattare il titolare del trattamento pu&ograve; essere utilizzata la mail {{ $email_parrocchia }};</li>
<li>i dati da Voi conferiti sono richiesti e saranno trattati unicamente per organizzare le attivit&agrave; promosse da {{ $nome_parrocchia }};</li>
<li>i medesimi dati non saranno comunicati a soggetti terzi, fatto salvo l&rsquo;ente {{ $nome_diocesi }} e le altre persone giuridiche canoniche, se e nei limiti previsti dall&rsquo;ordinamento canonico, che assumono la veste di contitolari del trattamento;</li>
<li>i dati conferiti saranno conservati fino al termine delle attivit&agrave; svolte; alcuni dati potranno essere conservati anche oltre tale periodo se e nei limiti in cui tale conservazione risponda ad un legittimo interesse di {{ $nome_parrocchia }};</li>
<li>l\'interessato pu&ograve; chiedere a {{ $nome_parrocchia }} l\'accesso ai dati personali (propri e del figlio/della figlia), la rettifica o la cancellazione degli stessi, la limitazione del trattamento che lo riguarda oppure pu&ograve; opporsi al loro trattamento; tale richiesta avr&agrave; effetto nei confronti di tutti i contitolari del trattamento;</li>
<li>l&rsquo;interessato pu&ograve;, altres&igrave;, proporre reclamo all&rsquo;Autorit&agrave; di controllo</li>
</ol>
<p><strong>Tenuto conto che il trattamento dei dati personali sopra indicati &egrave; limitato alle sole finalit&agrave; di cui alla lett. c) dell&rsquo;Informativa, considerato che il trattamento dei dati personali &Egrave; NECESSARIO per permettere alla Parrocchia di realizzare in sicurezza le iniziative sopra indicate (compilazione elenchi interni per controllo presenze, ...) e che dunque l&rsquo;eventuale diniego al trattamento dei dati personali sopra indicati impedisce alla medesima di accogliere la richiesta di iscrizione/partecipazione, letta e ricevuta l&rsquo;Informativa Privacy, prendiamo atto di quanto sopra in ordine al trattamento dei dati per le finalit&agrave; indicate alla lettera c) dell&rsquo;Informativa.</strong></p>',
        'titolo' => 'Informativa e consenso ai fini privacy e riservatezza',
      ),
      'riservatezza' => 
      array (
        'iscrizione' => 
        array (
          'mostra' => '1',
          'obbligatorio' => '1',
        ),
        'testo' => '<p>Il trattamento dei dati sanitari forniti &egrave; soggetto alla normativa canonica in vigore. {{ $nome_parrocchia }} dichiara che i dati conferiti saranno utilizzati, quando necessario, ogniqualvolta Vostro/a figlio/a sar&agrave; affidato alle sue cure nell&rsquo;ambito della conduzione dell\'evento "{{ $nome_evento }}" e non saranno diffusi o comunicati ad altri soggetti. L&rsquo;eventuale mancanza di comunicazione di elementi sanitari necessari al sicuro accudimento del minore ricade sotto l&rsquo;esclusiva responsabilit&agrave; della famiglia; il relativo consenso in tema di tutela della riservatezza &Egrave; NECESSARIO per permettere alla Parrocchia di realizzare in sicurezza le iniziative inerenti l\'evento in questione. &Egrave; comunque possibile richiedere alla Parrocchia la cancellazione dei propri dati.</p>',
        'titolo' => 'Informativa relativa alla tutela della riservatezza, in relazione ai dati personali raccolti per le attività educative della parrocchia.',
      ),
      'trattamento_foto' => 
      array (
        'iscrizione' => 
        array (
          'mostra' => '1',
          'obbligatorio' => '0',
        ),
        'testo' => '<p>Gentili Signori, desideriamo informarVi che il Regolamento UE 2016/679 e il Decreto Generale della CEI del 24 maggio 2018 prevedono la tutela delle persone ogniqualvolta sono trattati dati che le riguardano. Nel rispetto della normativa vigente il trattamento dei dati sar&agrave; svolto da {{ $nome_parrocchia }} in modo lecito, corretto e trasparente nei confronti dell\'interessato, assicurando la tutela dei suoi diritti. Ai sensi degli articoli 13 e seguenti del Regolamento UE 2016/679 e degli articoli 6 e seguenti del Decreto Generale CEI si precisa che:</p>
<ol>
<li>il titolare del trattamento &egrave; l&rsquo;ente {{ $nome_parrocchia }}, con sede in {{ $indirizzo_parrocchia }}, legalmente rappresentata dal parroco pro tempore;</li>
<li>per contattare il titolare del trattamento pu&ograve; essere utilizzata la mail {{ $email_parrocchia }};</li>
<li>le foto ed i video saranno trattati unicamente per:
<ul>
<li>dare evidenza delle attivit&agrave; promosse dalla Parrocchia alle quali ha partecipato il figlio/la figlia, anche attraverso pubblicazioni cartacee (bollettino parrocchiale, bacheca in oratorio, volantino &hellip;), nonch&eacute; la pagina web e i &ldquo;social&rdquo; della Parrocchia;</li>
<li>finalit&agrave; di archiviazione e documentazione delle attivit&agrave; promosse dalla Parrocchia.</li>
</ul>
</li>
<li>le foto ed i video non saranno comunicati a soggetti terzi, fatto salvo l&rsquo;ente Diocesi di Bergamo e le altre persone giuridiche canoniche;</li>
<li>{{ $nome_parrocchia }} si impegna ad adottare idonei strumenti a protezione delle immagini pubblicate sulla pagina web e sui &ldquo;social&rdquo;;</li>
<li>le foto ed i video saranno conservati e trattati fino a revoca del consenso;</li>
<li>l\'interessato pu&ograve; chiedere a {{ $nome_parrocchia }} l\'accesso ai dati personali, la rettifica o la cancellazione degli stessi, la limitazione del trattamento oppure pu&ograve; opporsi al loro trattamento;</li>
<li>l&rsquo;interessato pu&ograve;, altres&igrave;, proporre reclamo all&rsquo;Autorit&agrave; di controllo;</li>
<li>{{ $nome_parrocchia }} non utilizza processi decisionali automatizzati, compresa la profilazione di cui all&rsquo;articolo 22, paragrafi 1 e 4 del Regolamento UE 2016/679.</li>
</ol>',
        'titolo' => 'Informativa e CONSENSO al trattamento di fotografie e video',
      ),
    ),
    'privacy_policy' => 
    array (
      'email_parrocchia' => 'EMAIL',
      'indirizzo_parrocchia' => 'INDIRIZZO',
      'nome_parrocchia' => 'PARROCCHIA',
    ),
  ),
  'attributo' => 
  array (
    'name' => 'Attributo',
    'permissions' => 
    array (
      'view-attributo' => 'Visualizza la finestra degli attributi',
      'edit-attributo' => 'Modifica gli attributi degli utenti',
    ),
  ),
  'audit' => 
  array (
    'enabled' => true,
    'implementation' => 'OwenIt\\Auditing\\Models\\Audit',
    'user' => 
    array (
      'morph_prefix' => 'user',
      'guards' => 
      array (
        0 => 'web',
        1 => 'api',
      ),
    ),
    'resolver' => 
    array (
      'user' => 'OwenIt\\Auditing\\Resolvers\\UserResolver',
      'ip_address' => 'OwenIt\\Auditing\\Resolvers\\IpAddressResolver',
      'user_agent' => 'OwenIt\\Auditing\\Resolvers\\UserAgentResolver',
      'url' => 'OwenIt\\Auditing\\Resolvers\\UrlResolver',
    ),
    'events' => 
    array (
      0 => 'created',
      1 => 'updated',
      2 => 'deleted',
      3 => 'restored',
    ),
    'strict' => false,
    'timestamps' => false,
    'threshold' => 0,
    'driver' => 'database',
    'drivers' => 
    array (
      'database' => 
      array (
        'table' => 'audits',
        'connection' => NULL,
      ),
    ),
    'console' => false,
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'Modules\\User\\Entities\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'backup' => 
  array (
    'backup' => 
    array (
      'name' => 'Segresta 2.0',
      'enable' => true,
      'source' => 
      array (
        'files' => 
        array (
          'include' => 
          array (
            0 => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage',
          ),
          'exclude' => 
          array (
            0 => '/home/roberto/Documenti/Clienti/Segresta/segresta/vendor',
            1 => '/home/roberto/Documenti/Clienti/Segresta/segresta/node_modules',
          ),
          'follow_links' => false,
        ),
        'databases' => 
        array (
          0 => 'mysql',
        ),
      ),
      'database_dump_compressor' => NULL,
      'destination' => 
      array (
        'filename_prefix' => '',
        'disks' => 
        array (
          0 => 'dropbox',
        ),
      ),
      'temporary_directory' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/app/backup-temp',
    ),
    'notifications' => 
    array (
      'notifications' => 
      array (
        'Spatie\\Backup\\Notifications\\Notifications\\BackupHasFailed' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\UnhealthyBackupWasFound' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\CleanupHasFailed' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\BackupWasSuccessful' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\HealthyBackupWasFound' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\CleanupWasSuccessful' => 
        array (
          0 => 'mail',
        ),
      ),
      'notifiable' => 'Spatie\\Backup\\Notifications\\Notifiable',
      'mail' => 
      array (
        'to' => NULL,
        'from' => 
        array (
          'address' => NULL,
          'name' => NULL,
        ),
      ),
      'slack' => 
      array (
        'webhook_url' => '',
        'channel' => NULL,
        'username' => NULL,
        'icon' => NULL,
      ),
    ),
    'monitor_backups' => 
    array (
      0 => 
      array (
        'name' => 'Segresta 2.0',
        'disks' => 
        array (
          0 => 'local',
        ),
        'health_checks' => 
        array (
          'Spatie\\Backup\\Tasks\\Monitor\\HealthChecks\\MaximumAgeInDays' => 1,
          'Spatie\\Backup\\Tasks\\Monitor\\HealthChecks\\MaximumStorageInMegabytes' => 5000,
        ),
      ),
    ),
    'cleanup' => 
    array (
      'strategy' => 'Spatie\\Backup\\Tasks\\Cleanup\\Strategies\\DefaultStrategy',
      'default_strategy' => 
      array (
        'keep_all_backups_for_days' => 3,
        'keep_daily_backups_for_days' => 16,
        'keep_weekly_backups_for_weeks' => 8,
        'keep_monthly_backups_for_months' => 4,
        'keep_yearly_backups_for_years' => 2,
        'delete_oldest_backups_when_using_more_megabytes_than' => 1500,
      ),
    ),
    'enable' => '0',
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'array',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/framework/cache',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
    'prefix' => 'laravel',
  ),
  'certificazione' => 
  array (
    'name' => 'Certificazione',
    'permissions' => 
    array (
      'view-certificazione' => 'Visualizza la finestra certificazione',
      'edit-certificazione' => 'Modifica le informazioni certificazione',
      'delete-certificazione' => 'Cancella una certificazione',
      'edit-certificazione-segreteria' => 'Visualizza/Modifica tutte le certificazioni (come segreteria)',
    ),
  ),
  'compile' => 
  array (
    'files' => 
    array (
    ),
    'providers' => 
    array (
    ),
  ),
  'contabilita' => 
  array (
    'name' => 'Contabilita',
    'permissions' => 
    array (
      'edit-contabilita-opzioni' => 'Modifica le opzioni contabilità',
      'edit-contabilita' => 'Modifica la contabilità',
      'view-modello-ricevuta' => 'Vedi i modelli ricevute',
      'edit-modello-ricevuta' => 'Modifica modelli ricevute',
    ),
  ),
  'cookie-consent' => 
  array (
    'enabled' => true,
    'cookie_name' => 'laravel_cookie_consent',
    'cookie_lifetime' => 7300,
  ),
  'database' => 
  array (
    'fetch' => 5,
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'database' => 'segresta',
        'prefix' => '',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'segresta',
        'username' => 'segresta',
        'password' => 'UW8Z3UjNVZRizAvI',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'strict' => false,
        'engine' => 'innodb',
        'dump' => 
        array (
          'add_extra_option' => '-u segresta',
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'segresta',
        'username' => 'segresta',
        'password' => 'UW8Z3UjNVZRizAvI',
        'charset' => 'utf8',
        'prefix' => '',
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'predis',
      'default' => 
      array (
        'host' => 'localhost',
        'password' => 'segresta2020',
        'port' => 6379,
        'database' => 0,
        'read_write_timeout' => 60,
      ),
      'cache' => 
      array (
        'host' => '127.0.0.1',
        'password' => 'segresta2020',
        'port' => 6379,
        'database' => 1,
      ),
      'horizon' => 
      array (
        'host' => 'localhost',
        'password' => 'segresta2020',
        'port' => 6379,
        'database' => 0,
        'read_write_timeout' => 60,
        'options' => 
        array (
          'prefix' => 'horizon:',
        ),
      ),
    ),
  ),
  'datatables' => 
  array (
    'search' => 
    array (
      'smart' => true,
      'multi_term' => true,
      'case_insensitive' => true,
      'use_wildcards' => false,
    ),
    'index_column' => 'DT_RowIndex',
    'engines' => 
    array (
      'eloquent' => 'Yajra\\DataTables\\EloquentDataTable',
      'query' => 'Yajra\\DataTables\\QueryDataTable',
      'collection' => 'Yajra\\DataTables\\CollectionDataTable',
      'resource' => 'Yajra\\DataTables\\ApiResourceDataTable',
    ),
    'builders' => 
    array (
    ),
    'nulls_last_sql' => '%s %s NULLS LAST',
    'error' => NULL,
    'columns' => 
    array (
      'excess' => 
      array (
        0 => 'rn',
        1 => 'row_num',
      ),
      'escape' => '*',
      'raw' => 
      array (
        0 => 'action',
      ),
      'blacklist' => 
      array (
        0 => 'password',
        1 => 'remember_token',
      ),
      'whitelist' => '*',
    ),
    'json' => 
    array (
      'header' => 
      array (
      ),
      'options' => 0,
    ),
  ),
  'datatables-buttons' => 
  array (
    'namespace' => 
    array (
      'base' => 'DataTables',
      'model' => '',
    ),
    'pdf_generator' => 'snappy',
    'snappy' => 
    array (
      'options' => 
      array (
        'no-outline' => true,
        'margin-left' => '0',
        'margin-right' => '0',
        'margin-top' => '10mm',
        'margin-bottom' => '10mm',
      ),
      'orientation' => 'landscape',
    ),
    'parameters' => 
    array (
      'dom' => 'Bfrtip',
      'order' => 
      array (
        0 => 
        array (
          0 => 0,
          1 => 'desc',
        ),
      ),
      'buttons' => 
      array (
        0 => 'create',
        1 => 'export',
        2 => 'print',
        3 => 'reset',
        4 => 'reload',
      ),
    ),
    'generator' => 
    array (
      'columns' => 'id,add your columns,created_at,updated_at',
      'buttons' => 'create,export,print,reset,reload',
      'dom' => 'Bfrtip',
    ),
  ),
  'datatables-html' => 
  array (
    'table' => 
    array (
      'class' => 'table',
      'id' => 'dataTableBuilder',
    ),
    'callback' => 
    array (
      0 => '$',
      1 => '$.',
      2 => 'function',
    ),
    'script' => 'datatables::script',
    'editor' => 'datatables::editor',
  ),
  'diocesi' => 
  array (
    'name' => 'Diocesi',
    'email' => 'admin@email.it',
    'permissions' => 
    array (
      'edit-oratori' => 'Modifica e aggiungi oratori',
      'view-users-diocesi' => 'Vedi gli utenti di tutti gli oratori',
      'add-events-diocesi' => 'Aggiungi eventi diocesani',
    ),
  ),
  'dompdf' => 
  array (
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => 
    array (
      'font_dir' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/fonts/',
      'font_cache' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/fonts/',
      'temp_dir' => '/tmp',
      'chroot' => '/home/roberto/Documenti/Clienti/Segresta/segresta',
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => false,
    ),
  ),
  'elenco' => 
  array (
    'name' => 'Elenco',
  ),
  'email' => 
  array (
    'name' => 'Email',
    'permissions' => 
    array (
      'view-email' => 'Archivio Email',
      'send-email' => 'Invia email',
    ),
  ),
  'entrust' => 
  array (
    'role' => 'App\\Role',
    'roles_table' => 'roles',
    'permission' => 'App\\Permission',
    'permissions_table' => 'permissions',
    'permission_role_table' => 'permission_role',
    'role_user_table' => 'role_user',
    'user_foreign_key' => 'user_id',
    'role_foreign_key' => 'role_id',
  ),
  'event' => 
  array (
    'name' => 'Event',
    'permissions' => 
    array (
      'view-event' => 'Visualizza la finestra degli eventi',
      'edit-event' => 'Modifica le informazioni degli eventi',
      'manage-week' => 'Visualizza e modifica le settimane',
    ),
  ),
  'excel' => 
  array (
    'exports' => 
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ),
    ),
    'imports' => 
    array (
      'read_only' => true,
      'heading_row' => 
      array (
        'formatter' => 'slug',
      ),
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ),
    ),
    'extension_detector' => 
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' => 
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' => 
    array (
      'driver' => 'memory',
      'batch' => 
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' => 
      array (
        'store' => NULL,
      ),
    ),
    'transactions' => 
    array (
      'handler' => 'db',
    ),
    'temporary_files' => 
    array (
      'local_path' => '/tmp',
      'remote_disk' => NULL,
    ),
  ),
  'famiglia' => 
  array (
    'name' => 'Famiglia',
    'permissions' => 
    array (
      'view-famiglia' => 'Visualizza la famiglia',
      'edit-famiglia' => 'Modifica le informazioni sulla famiglia',
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 'webdav',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/app',
      ),
      'log' => 
      array (
        'driver' => 'local',
        'root' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/logs',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/app/public',
        'visibility' => 'public',
        'url' => 'http://192.168.7.102:8000/storage',
      ),
      'webdav' => 
      array (
        'driver' => 'webdav',
        'baseUri' => 'https://cloud.elephantech.it/remote.php/webdav/',
        'userName' => 'oratorio',
        'password' => 'Oratorio2019!',
        'pathPrefix' => '',
      ),
      'modelli_certificazioni' => 
      array (
        'driver' => 'local',
        'root' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/app/public/modelli_certificazioni',
        'url' => 'http://192.168.7.102:8000/storage/modelli_certificazioni',
        'visibility' => 'public',
      ),
      'modelli_ricevute' => 
      array (
        'driver' => 'local',
        'root' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/app/public/modelli_ricevute',
        'url' => 'http://192.168.7.102:8000/storage/modelli_ricevute',
        'visibility' => 'public',
      ),
      'certificazioni' => 
      array (
        'driver' => 'local',
        'root' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/app/public/certificazioni',
        'url' => 'http://192.168.7.102:8000/storage/certificazioni',
        'visibility' => 'public',
      ),
      'ricevute' => 
      array (
        'driver' => 'local',
        'root' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/app/public/ricevute',
        'url' => 'http://192.168.7.102:8000/storage/ricevute',
        'visibility' => 'public',
      ),
      'dropbox' => 
      array (
        'driver' => 'dropbox',
        'authorization_token' => 'RjbCbfIqHnIAAAAAAAAn2JcRU5Y1gjs-H92_NUhBtDWdgn1te9l1diCBLUK9Us5v',
      ),
    ),
  ),
  'firebase' => 
  array (
    'credentials' => 
    array (
      'file' => 'Modules/Firebase/segresta-c2226-firebase-adminsdk-xe831-2e0df263f4.json',
      'auto_discovery' => true,
    ),
    'database' => 
    array (
      'url' => NULL,
    ),
    'dynamic_links' => 
    array (
      'default_domain' => NULL,
    ),
    'storage' => 
    array (
      'default_bucket' => NULL,
    ),
    'cache_store' => 'file',
    'logging' => 
    array (
      'http_log_channel' => NULL,
      'http_debug_log_channel' => NULL,
    ),
    'debug' => false,
  ),
  'generators' => 
  array (
    'config' => 
    array (
      'model_template_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/vendor/xethron/laravel-4-generators/src/Way/Generators/templates/model.txt',
      'scaffold_model_template_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/vendor/xethron/laravel-4-generators/src/Way/Generators/templates/scaffolding/model.txt',
      'controller_template_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/vendor/xethron/laravel-4-generators/src/Way/Generators/templates/controller.txt',
      'scaffold_controller_template_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/vendor/xethron/laravel-4-generators/src/Way/Generators/templates/scaffolding/controller.txt',
      'migration_template_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/vendor/xethron/laravel-4-generators/src/Way/Generators/templates/migration.txt',
      'seed_template_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/vendor/xethron/laravel-4-generators/src/Way/Generators/templates/seed.txt',
      'view_template_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/vendor/xethron/laravel-4-generators/src/Way/Generators/templates/view.txt',
      'model_target_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/app',
      'controller_target_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/app/Http/Controllers',
      'migration_target_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/database/migrations',
      'seed_target_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/database/seeds',
      'view_target_path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/resources/views',
    ),
  ),
  'group' => 
  array (
    'name' => 'Group',
    'permissions' => 
    array (
      'view-gruppo' => 'Visualizza la finestra dei gruppi',
      'edit-gruppo' => 'Modifica gruppi e componenti',
    ),
  ),
  'horizon' => 
  array (
    'domain' => NULL,
    'path' => 'horizon',
    'use' => 'default',
    'prefix' => 'horizon:',
    'middleware' => 
    array (
      0 => 'web',
    ),
    'waits' => 
    array (
      'redis:default' => 60,
    ),
    'trim' => 
    array (
      'recent' => 60,
      'recent_failed' => 10080,
      'failed' => 10080,
      'monitored' => 10080,
    ),
    'fast_termination' => false,
    'memory_limit' => 64,
    'environments' => 
    array (
      'production' => 
      array (
        'supervisor-1' => 
        array (
          'connection' => 'redis',
          'queue' => 
          array (
            0 => 'default',
          ),
          'balance' => 'simple',
          'processes' => 3,
          'tries' => 3,
        ),
      ),
      'local' => 
      array (
        'supervisor-1' => 
        array (
          'connection' => 'redis',
          'queue' => 
          array (
            0 => 'default',
          ),
          'balance' => 'simple',
          'processes' => 3,
          'tries' => 3,
        ),
      ),
    ),
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'laravel-cookie-consent' => 
  array (
    'enabled' => true,
    'cookie_name' => 'laravel_cookie_consent',
  ),
  'laravel-menu' => 
  array (
    'settings' => 
    array (
      'default' => 
      array (
        'auto_activate' => true,
        'activate_parents' => true,
        'active_class' => 'active',
        'restful' => false,
        'cascade_data' => true,
        'rest_base' => '',
        'active_element' => 'item',
      ),
    ),
    'views' => 
    array (
      'bootstrap-items' => 'laravel-menu::bootstrap-navbar-items',
    ),
  ),
  'logging' => 
  array (
    'default' => 'daily',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 7,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
    'host' => 'out.postassl.it',
    'port' => '465',
    'from' => 
    array (
      'address' => 'info@elephantech.it',
      'name' => 'ElephanTech',
    ),
    'encryption' => 'ssl',
    'username' => 'info@elephantech.it',
    'password' => 'cQVz3~B~hyvuwjtr',
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/home/roberto/Documenti/Clienti/Segresta/segresta/resources/views/vendor/mail',
      ),
    ),
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
  ),
  'modules' => 
  array (
    'namespace' => 'Modules',
    'stubs' => 
    array (
      'enabled' => false,
      'path' => '/home/roberto/Documenti/Clienti/Segresta/segresta/vendor/nwidart/laravel-modules/src/Commands/stubs',
      'files' => 
      array (
        'start' => 'start.php',
        'routes' => 'Http/routes.php',
        'views/index' => 'Resources/views/index.blade.php',
        'views/master' => 'Resources/views/layouts/master.blade.php',
        'scaffold/config' => 'Config/config.php',
        'composer' => 'composer.json',
      ),
      'replacements' => 
      array (
        'start' => 
        array (
          0 => 'LOWER_NAME',
          1 => 'ROUTES_LOCATION',
        ),
        'routes' => 
        array (
          0 => 'LOWER_NAME',
          1 => 'STUDLY_NAME',
          2 => 'MODULE_NAMESPACE',
        ),
        'json' => 
        array (
          0 => 'LOWER_NAME',
          1 => 'STUDLY_NAME',
          2 => 'MODULE_NAMESPACE',
        ),
        'views/index' => 
        array (
          0 => 'LOWER_NAME',
        ),
        'views/master' => 
        array (
          0 => 'STUDLY_NAME',
        ),
        'scaffold/config' => 
        array (
          0 => 'STUDLY_NAME',
        ),
        'composer' => 
        array (
          0 => 'LOWER_NAME',
          1 => 'STUDLY_NAME',
          2 => 'VENDOR',
          3 => 'AUTHOR_NAME',
          4 => 'AUTHOR_EMAIL',
          5 => 'MODULE_NAMESPACE',
        ),
      ),
      'gitkeep' => true,
    ),
    'paths' => 
    array (
      'modules' => '/home/roberto/Documenti/Clienti/Segresta/segresta/Modules',
      'assets' => '/home/roberto/Documenti/Clienti/Segresta/segresta/public/modules',
      'migration' => '/home/roberto/Documenti/Clienti/Segresta/segresta/database/migrations',
      'generator' => 
      array (
        'config' => 
        array (
          'path' => 'Config',
          'generate' => true,
        ),
        'command' => 
        array (
          'path' => 'Console',
          'generate' => true,
        ),
        'migration' => 
        array (
          'path' => 'Database/Migrations',
          'generate' => true,
        ),
        'seeder' => 
        array (
          'path' => 'Database/Seeders',
          'generate' => true,
        ),
        'factory' => 
        array (
          'path' => 'Database/factories',
          'generate' => true,
        ),
        'model' => 
        array (
          'path' => 'Entities',
          'generate' => true,
        ),
        'controller' => 
        array (
          'path' => 'Http/Controllers',
          'generate' => true,
        ),
        'filter' => 
        array (
          'path' => 'Http/Middleware',
          'generate' => true,
        ),
        'request' => 
        array (
          'path' => 'Http/Requests',
          'generate' => true,
        ),
        'provider' => 
        array (
          'path' => 'Providers',
          'generate' => true,
        ),
        'assets' => 
        array (
          'path' => 'Resources/assets',
          'generate' => true,
        ),
        'lang' => 
        array (
          'path' => 'Resources/lang',
          'generate' => true,
        ),
        'views' => 
        array (
          'path' => 'Resources/views',
          'generate' => true,
        ),
        'test' => 
        array (
          'path' => 'Tests',
          'generate' => true,
        ),
        'repository' => 
        array (
          'path' => 'Repositories',
          'generate' => false,
        ),
        'event' => 
        array (
          'path' => 'Events',
          'generate' => false,
        ),
        'listener' => 
        array (
          'path' => 'Listeners',
          'generate' => false,
        ),
        'policies' => 
        array (
          'path' => 'Policies',
          'generate' => false,
        ),
        'rules' => 
        array (
          'path' => 'Rules',
          'generate' => false,
        ),
        'jobs' => 
        array (
          'path' => 'Jobs',
          'generate' => false,
        ),
        'emails' => 
        array (
          'path' => 'Emails',
          'generate' => false,
        ),
        'notifications' => 
        array (
          'path' => 'Notifications',
          'generate' => false,
        ),
        'resource' => 
        array (
          'path' => 'Transformers',
          'generate' => false,
        ),
      ),
    ),
    'scan' => 
    array (
      'enabled' => false,
      'paths' => 
      array (
        0 => '/home/roberto/Documenti/Clienti/Segresta/segresta/vendor/*/*',
      ),
    ),
    'composer' => 
    array (
      'vendor' => 'nwidart',
      'author' => 
      array (
        'name' => 'Nicolas Widart',
        'email' => 'n.widart@gmail.com',
      ),
    ),
    'cache' => 
    array (
      'enabled' => false,
      'key' => 'laravel-modules',
      'lifetime' => 60,
    ),
    'register' => 
    array (
      'translations' => true,
      'files' => 'register',
    ),
  ),
  'modulo' => 
  array (
    'name' => 'Modulo',
    'permissions' => 
    array (
      'view-modulo' => 'Visualizza la finestra dei moduli',
      'edit-modulo' => 'Modifica le informazioni dei moduli',
    ),
  ),
  'oratorio' => 
  array (
    'name' => 'Oratorio',
    'permissions' => 
    array (
      'view-select' => 'Visualizza gli elenchi con tutte le opzioni',
      'edit-select' => 'Modifica gli elenchi con tutte le opzioni',
      'edit-oratorio' => 'Modifica le informazioni relative all\'oratorio',
      'edit-permission' => 'Gestisci permessi',
    ),
  ),
  'queue' => 
  array (
    'default' => 'redis',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'your-public-key',
        'secret' => 'your-secret-key',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 1200,
        'block_for' => NULL,
      ),
    ),
    'failed' => 
    array (
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'registropresenze' => 
  array (
    'name' => 'Registro Presenze',
    'permissions' => 
    array (
      'view-registro_presenze' => 'Visualizza i registri presenze',
      'edit-registro_presenze' => 'Modifica i registri presenze',
    ),
  ),
  'report' => 
  array (
    'name' => 'Report',
    'permissions' => 
    array (
      'generate-report' => 'Genera report',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
    'sparkpost' => 
    array (
      'secret' => NULL,
    ),
    'stripe' => 
    array (
      'model' => 'Modules\\User\\Entities\\User',
      'key' => NULL,
      'secret' => NULL,
    ),
    'google' => 
    array (
      'client_id' => '222725687752-rdues2edc7rabretqhv605olg8rmre2v.apps.googleusercontent.com',
      'client_secret' => 'X6JdT4TAWHhSM8sPUU49wLUr',
      'redirect' => 'http://192.168.7.102:8000/auth/google/callback',
    ),
    'facebook' => 
    array (
      'client_id' => '573215073574741',
      'client_secret' => '008679dea9d7b630780b53413aca90d3',
      'redirect' => 'http://192.168.7.102:8000/auth/facebook/callback',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
  ),
  'sms' => 
  array (
    'name' => 'Sms',
    'permissions' => 
    array (
      'view-sms' => 'Vedi archivio SMS',
      'send-sms' => 'Invia SMS',
    ),
  ),
  'subscription' => 
  array (
    'name' => 'Subscription',
    'permissions' => 
    array (
      'view-iscrizioni' => 'Visualizza iscrizioni',
      'edit-iscrizioni' => 'Modifica iscrizioni',
      'edit-admin-iscrizioni' => 'Modifica iscrizioni come segreteria',
    ),
  ),
  'telegram' => 
  array (
    'bot_token' => '305880668:AAHY8PzersKLz2LD7yGxYtZ_12x3-eUiNQU',
    'async_requests' => false,
    'http_client_handler' => NULL,
    'commands' => 
    array (
    ),
  ),
  'user' => 
  array (
    'name' => 'User',
    'permissions' => 
    array (
      'view-users' => 'Visualizza la finestra dell\'anagrafica',
      'edit-users' => 'Modifica le informazioni degli utenti',
    ),
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/home/roberto/Documenti/Clienti/Segresta/segresta/resources/views',
    ),
    'compiled' => '/home/roberto/Documenti/Clienti/Segresta/segresta/storage/framework/views',
  ),
  'whatsapp' => 
  array (
    'name' => 'Whatsapp',
  ),
  'datatables-fractal' => 
  array (
    'includes' => 'include',
    'serializer' => 'League\\Fractal\\Serializer\\DataArraySerializer',
  ),
  'volontario' => 
  array (
    'name' => 'Volontario',
    'permissions' => 
    array (
      'view-volontario' => 'Vedi elenco volontari',
      'edit-volontario' => 'Modifica elenco volontari',
      'view-edit-gruppi-volontario' => 'Vedi elenco gruppi volontari',
      'volontario-segreteria' => 'Gestisci i volontari come segreteria',
    ),
  ),
);

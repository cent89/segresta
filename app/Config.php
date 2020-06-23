<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Illuminate\Support\Facades\Blade;

class Config extends Model
{
protected $table = "config";
protected $fillable = ['key', 'value', 'display_name', 'group', 'order', 'config'];
protected $primaryKey = 'key';

protected $casts = [
    'key' => 'string',
    'display_name' => 'string',
    'value' => 'string',
    'type' => 'string',
    'created_at' => 'datetime',
    'updated_at' => 'datetime'
];

public static $gdpr_titolo_default = 'Raccolta dati per l’attività "{{ $nome_evento }}" (art. 16, L. n. 222/85) promosse da {{ $nome_parrocchia }}';
public static $gdpr_testo_default = '<p>
  Tenuto conto di quanto previsto dall’art. 91 del Regolamento UE 2016/679, il trattamento dei dati personali da Voi conferiti compilando
  le pagine precedenti è soggetto al Decreto Generale della CEI "Disposizioni per la tutela del diritto alla buona fama e alla riservatezza
  dei dati relativi alle persone dei fedeli, degli enti ecclesiastici e delle aggregazioni laicali" del 24 maggio 2018.
</p>
<p>
  Ai sensi degli articoli 6 e 7 del Decreto Generale CEI si precisa che:
</p>
<ol type="a">
  <li>il titolare del trattamento è l’ente {{ $nome_parrocchia }}, con sede in {{ $indirizzo_parrocchia }},
    legalmente rappresentata dal parroco pro tempore;</li>
  <li>per contattare il titolare del trattamento può essere utilizzata la mail {{ $email_parrocchia }};</li>
  <li>i dati da Voi conferiti sono richiesti e saranno trattati unicamente per organizzare le attività inerenti l\'evento "{{ $nome_evento }}" promosse da {{ $nome_parrocchia }};</li>
  <li>i medesimi dati non saranno comunicati a soggetti terzi, fatto salvo l’ente {{ $nome_diocesi }} e le altre persone giuridiche canoniche,
    se e nei limiti previsti dall’ordinamento canonico, che assumono la veste di contitolari del trattamento;</li>
  <li>i dati conferiti saranno conservati fino al termine delle attività inerenti l\'evento "{{ $nome_evento }}";
    alcuni dati potranno essere conservati anche oltre tale periodo se e nei limiti in cui tale conservazione risponda ad un legittimo interesse di {{ $nome_parrocchia }};</li>
  <li>l\'interessato può chiedere a {{ $nome_parrocchia }} l\'accesso ai dati personali (propri e del figlio/della figlia),
    la rettifica o la cancellazione degli stessi, la limitazione del trattamento che lo riguarda oppure può opporsi al loro trattamento;
    tale richiesta avrà effetto nei confronti di tutti i contitolari del trattamento;</li>
  <li>l’interessato può, altresì, proporre reclamo all’Autorità di controllo</li>
</ol>
<p>
  <b>Tenuto conto che il trattamento dei dati personali sopra indicati è limitato alle sole finalità di cui alla lett. c) dell’Informativa,
  considerato che il trattamento dei dati personali È NECESSARIO per permettere alla Parrocchia di realizzare in sicurezza le iniziative sopra indicate
  (compilazione elenchi interni per controllo presenze, ...) e che dunque l’eventuale diniego al trattamento dei dati personali sopra indicati
  impedisce alla medesima di accogliere la richiesta di iscrizione/partecipazione, letta e ricevuta l’Informativa Privacy,
  prendiamo atto di quanto sopra in ordine al trattamento dei dati per le finalità indicate alla lettera c) dell’Informativa.</b>
</p>';

public static $gdpr_registrazione_titolo_default = 'Informativa e consenso ai fini privacy e riservatezza';
public static $gdpr_registrazione_testo_default = '<p>
  Tenuto conto di quanto previsto dall’art. 91 del Regolamento UE 2016/679, il trattamento dei dati personali da Voi conferiti compilando
  le pagine precedenti è soggetto al Decreto Generale della CEI "Disposizioni per la tutela del diritto alla buona fama e alla riservatezza
  dei dati relativi alle persone dei fedeli, degli enti ecclesiastici e delle aggregazioni laicali" del 24 maggio 2018.
</p>
<p>
  Ai sensi degli articoli 6 e 7 del Decreto Generale CEI si precisa che:
</p>
<ol type="a">
  <li>il titolare del trattamento è l’ente {{ $nome_parrocchia }}, con sede in {{ $indirizzo_parrocchia }},
    legalmente rappresentata dal parroco pro tempore;</li>
  <li>per contattare il titolare del trattamento può essere utilizzata la mail {{ $email_parrocchia }};</li>
  <li>i dati da Voi conferiti sono richiesti e saranno trattati unicamente per organizzare le attività promosse da {{ $nome_parrocchia }};</li>
  <li>i medesimi dati non saranno comunicati a soggetti terzi, fatto salvo l’ente {{ $nome_diocesi }} e le altre persone giuridiche canoniche,
    se e nei limiti previsti dall’ordinamento canonico, che assumono la veste di contitolari del trattamento;</li>
  <li>i dati conferiti saranno conservati fino al termine delle attività svolte;
    alcuni dati potranno essere conservati anche oltre tale periodo se e nei limiti in cui tale conservazione risponda ad un legittimo interesse di {{ $nome_parrocchia }};</li>
  <li>l\'interessato può chiedere a {{ $nome_parrocchia }} l\'accesso ai dati personali (propri e del figlio/della figlia),
    la rettifica o la cancellazione degli stessi, la limitazione del trattamento che lo riguarda oppure può opporsi al loro trattamento;
    tale richiesta avrà effetto nei confronti di tutti i contitolari del trattamento;</li>
  <li>l’interessato può, altresì, proporre reclamo all’Autorità di controllo</li>
</ol>
<p>
  <b>Tenuto conto che il trattamento dei dati personali sopra indicati è limitato alle sole finalità di cui alla lett. c) dell’Informativa,
  considerato che il trattamento dei dati personali È NECESSARIO per permettere alla Parrocchia di realizzare in sicurezza le iniziative sopra indicate
  (compilazione elenchi interni per controllo presenze, ...) e che dunque l’eventuale diniego al trattamento dei dati personali sopra indicati
  impedisce alla medesima di accogliere la richiesta di iscrizione/partecipazione, letta e ricevuta l’Informativa Privacy,
  prendiamo atto di quanto sopra in ordine al trattamento dei dati per le finalità indicate alla lettera c) dell’Informativa.</b>
</p>';

public static $affiliazione_titolo_default = '';
public static $affiliazione_testo_default = '
<p>
  <b>Inoltre</b>, premesso che {{ $nome_parrocchia }} intenderebbe poter conservare ed utilizzare
  (ad esempio tramite creazione di mail-list o elenco telefonico) i dati conferiti in queste pagine <b>ANCHE</b> per comunicare le future iniziative ed attività da essa promosse;
  <br>che il predetto trattamento avrà termine qualora sia revocato il presente consenso;
  <br>tenuto conto che il trattamento per le suddette finalità <b>NON È NECESSARIO</b> per consentire alla Parrocchia di accogliere e dar corso
  alla richiesta di iscrizione/partecipazione di cui sopra e, dunque, l’eventuale diniego non impedisce l’accoglimento della medesima, letta e ricevuta l’Informativa Privacy
</p>';

public static $informativa_titolo_default = 'Informativa relativa alla tutela della riservatezza, in relazione ai dati personali raccolti per le attività educative della parrocchia.';
public static $informativa_testo_default = '<p>
  Il trattamento dei dati sanitari forniti è soggetto alla normativa canonica in vigore.
  {{ $nome_parrocchia }} dichiara che i dati conferiti saranno utilizzati, quando necessario, ogniqualvolta Vostro/a figlio/a sarà affidato
  alle sue cure nell’ambito della conduzione dell\'evento "{{ $nome_evento }}" e non saranno diffusi o comunicati ad altri soggetti.
  L’eventuale mancanza di comunicazione di elementi sanitari necessari al sicuro accudimento del minore ricade sotto l’esclusiva responsabilità della famiglia;
  il relativo consenso in tema di tutela della riservatezza È NECESSARIO per permettere alla Parrocchia di realizzare in sicurezza le iniziative inerenti l\'evento in questione.
  È comunque possibile richiedere alla Parrocchia la cancellazione dei propri dati.
</p>';

public static $trattamento_foto_titolo_default = 'Informativa e CONSENSO al trattamento di fotografie e video';
public static $trattamento_foto_testo_default = '<p>
  Gentili Signori, desideriamo informarVi che il Regolamento UE 2016/679 e il Decreto Generale della CEI del 24 maggio 2018 prevedono la tutela
  delle persone ogniqualvolta sono trattati dati che le riguardano.
  Nel rispetto della normativa vigente il trattamento dei dati sarà svolto da {{ $nome_parrocchia }} in modo lecito, corretto e trasparente
  nei confronti dell\'interessato, assicurando la tutela dei suoi diritti.
  Ai sensi degli articoli 13 e seguenti del Regolamento UE 2016/679 e degli articoli 6 e seguenti del Decreto Generale CEI si precisa che:
</p>
<ol>
  <li>il titolare del trattamento è l’ente {{ $nome_parrocchia }},
    con sede in {{ $indirizzo_parrocchia }}, legalmente rappresentata dal parroco pro tempore; </li>
    <li>per contattare il titolare del trattamento può essere utilizzata la mail {{ $email_parrocchia }};</li>
    <li>le foto ed i video saranno trattati unicamente per:
    <ul>
      <li>dare evidenza delle attività promosse dalla Parrocchia alle quali ha partecipato il figlio/la figlia,
        anche attraverso pubblicazioni cartacee (bollettino parrocchiale, bacheca in oratorio, volantino …),
        nonché la 	pagina web e i “social” della Parrocchia;
      </li>
      <li>
        finalità di archiviazione e documentazione delle attività promosse dalla Parrocchia.
      </li>
    </ul>
    <li>le foto ed i video non saranno comunicati a soggetti terzi, fatto salvo l’ente Diocesi di Bergamo e le altre persone giuridiche canoniche;</li>
    <li>{{ $nome_parrocchia }} si impegna ad adottare idonei strumenti a protezione delle immagini pubblicate sulla pagina web e sui “social”;</li>
    <li>le foto ed i video saranno conservati e trattati fino a revoca del consenso;</li>
    <li>l\'interessato può chiedere a {{ $nome_parrocchia }} l\'accesso ai dati personali, la rettifica o la cancellazione degli stessi,
      la limitazione del trattamento oppure può opporsi al loro trattamento; </li>
    <li>l’interessato può, altresì, proporre reclamo all’Autorità di controllo; </li>
    <li>{{ $nome_parrocchia }} non utilizza processi decisionali automatizzati, compresa la profilazione di cui all’articolo 22, paragrafi 1 e 4 del Regolamento UE 2016/679.</li>
  </li>
</ol>';


public static function getConfig(){
  return [
    ['key' => 'MAIL_DRIVER', 'config' => 'mail.driver', 'value' => 'smtp', 'display_name' => 'Email driver', 'type' => 'text', 'group' => 'Email'],
    ['key' => 'MAIL_ENCRYPTION', 'config' => 'mail.encryption', 'value' => 'ssl', 'display_name' => 'Email Encryption', 'type' => 'text', 'group' => 'Email'],
    ['key' => 'MAIL_FROM_ADDRESS', 'config' => 'mail.from.address', 'value' => '', 'display_name' => 'Indirizzo email con il quale inviare i messaggi', 'type' => 'text', 'group' => 'Email'],
    ['key' => 'MAIL_FROM_NAME', 'config' => 'mail.from.name', 'value' => '', 'display_name' => 'Nome con il quale inviare i messaggi', 'type' => 'text', 'group' => 'Email'],
    ['key' => 'MAIL_HOST', 'config' => 'mail.host', 'value' => '', 'display_name' => 'Host Email', 'type' => 'text', 'group' => 'Email'],
    ['key' => 'MAIL_PORT', 'config' => 'mail.port', 'value' => 465, 'display_name' => 'Porta Email', 'type' => 'text', 'group' => 'Email'],
    ['key' => 'MAIL_USERNAME', 'config' => 'mail.username', 'value' => '', 'display_name' => 'Username', 'type' => 'text', 'group' => 'Email'],
    ['key' => 'MAIL_PASSWORD', 'config' => 'mail.password', 'value' => '', 'display_name' => 'Password', 'type' => 'text', 'group' => 'Email'],
    ['key' => 'ENABLE_BACKUP', 'config' => 'backup.enable', 'value' => 1, 'display_name' => 'Abilita backup su Dropbox', 'type' => 'boolean', 'group' => 'Backup'],
    ['key' => 'DROPBOX_AUTH_TOKEN', 'config' => 'filesystems.disks.dropbox.authorization_token', 'value' => '', 'display_name' => 'Dropbox Auth Token', 'type' => 'text', 'group' => 'Backup'],

    ['key' => 'PRIVACY_GDPR_TITOLO', 'config' => 'app.privacy.gdpr.titolo', 'value' => self::$gdpr_titolo_default, 'display_name' => 'Titolo GDPR (iscrizioni)', 'type' => 'text', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_GDPR_TESTO', 'config' => 'app.privacy.gdpr.testo', 'value' => self::$gdpr_testo_default, 'display_name' => 'Testo GDPR (iscrizioni)', 'type' => 'textarea', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_GDPR_MOSTRA_ISCRIZIONE', 'config' => 'app.privacy.gdpr.iscrizione.mostra', 'value' => true, 'display_name' => 'Mostra GDPR in fase d\'iscrizione', 'type' => 'boolean', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_GDPR_OBBLIGATORIO_ISCRIZIONE', 'config' => 'app.privacy.gdpr.iscrizione.obbligatorio', 'value' => true, 'display_name' => 'Accettazione GDPR vincolante per l\'iscrizione agli eventi', 'type' => 'boolean', 'group' => 'GDPR'],

    ['key' => 'PRIVACY_GDPR_REGISTRAZIONE_TITOLO', 'config' => 'app.privacy.gdpr_registrazione.titolo', 'value' => self::$gdpr_registrazione_titolo_default, 'display_name' => 'Titolo GDPR (registrazione)', 'type' => 'text', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_GDPR_REGISTRAZIONE_TESTO', 'config' => 'app.privacy.gdpr_registrazione.testo', 'value' => self::$gdpr_registrazione_testo_default, 'display_name' => 'Testo GDPR (registrazione)', 'type' => 'textarea', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_GDPR_REGISTRAZIONE_MOSTRA', 'config' => 'app.privacy.gdpr_registrazione.mostra', 'value' => true, 'display_name' => 'Mostra GDPR in fase di registrazione alla piattaforma', 'type' => 'boolean', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_GDPR_REGISTRAZIONE_OBBLIGATORIO', 'config' => 'app.privacy.gdpr_registrazione.obbligatorio', 'value' => true, 'display_name' => 'Accettazione GDPR vincolante per la registrazione alla piattaforma', 'type' => 'boolean', 'group' => 'GDPR'],


    ['key' => 'PRIVACY_AFFILIAZIONE_TITOLO', 'config' => 'app.privacy.affiliazione.titolo', 'value' => self::$affiliazione_titolo_default, 'display_name' => 'Titolo Affiliazione', 'type' => 'text', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_AFFILIAZIONE_TESTO', 'config' => 'app.privacy.affiliazione.testo', 'value' => self::$affiliazione_testo_default, 'display_name' => 'Testo Affiliazione', 'type' => 'textarea', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_AFFILIAZIONE_MOSTRA_ISCRIZIONE', 'config' => 'app.privacy.affiliazione.iscrizione.mostra', 'value' => true, 'display_name' => 'Mostra Affiliazione in fase d\'iscrizione', 'type' => 'boolean', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_AFFILIAZIONE_OBBLIGATORIO_ISCRIZIONE', 'config' => 'app.privacy.affiliazione.iscrizione.obbligatorio', 'value' => true, 'display_name' => 'Accettazione Affiliazione vincolante per l\'iscrizione agli eventi', 'type' => 'boolean', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_AFFILIAZIONE_MOSTRA_REGISTRAZIONE', 'config' => 'app.privacy.affiliazione.registrazione.mostra', 'value' => true, 'display_name' => 'Mostra Affiliazione in fase di registrazione', 'type' => 'boolean', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_AFFILIAZIONE_OBBLIGATORIO_REGISTRAZIONE', 'config' => 'app.privacy.affiliazione.registrazione.obbligatorio', 'value' => true, 'display_name' => 'Accettazione Affiliazione vincolante per la registrazione alla piattaforma', 'type' => 'boolean', 'group' => 'GDPR'],

    ['key' => 'PRIVACY_RISERVATEZZA_TITOLO', 'config' => 'app.privacy.riservatezza.titolo', 'value' => self::$informativa_titolo_default, 'display_name' => 'Titolo Informativa', 'type' => 'text', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_RISERVATEZZA_TESTO', 'config' => 'app.privacy.riservatezza.testo', 'value' => self::$informativa_testo_default, 'display_name' => 'Informativa relativa alla tutela della riservatezza', 'type' => 'textarea', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_RISERVATEZZA_MOSTRA_ISCRIZIONE', 'config' => 'app.privacy.riservatezza.iscrizione.mostra', 'value' => true, 'display_name' => 'Mostra informativa relativa alla tutela della riservatezza in fase d\'iscrizione', 'type' => 'boolean', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_RISERVATEZZA_OBBLIGATORIO_ISCRIZIONE', 'config' => 'app.privacy.riservatezza.iscrizione.obbligatorio', 'value' => true, 'display_name' => 'Accettazione informativa vincolante per l\'iscrizione agli eventi', 'type' => 'boolean', 'group' => 'GDPR'],

    ['key' => 'PRIVACY_TRATTAMENTO_FOTO_TITOLO', 'config' => 'app.privacy.trattamento_foto.titolo', 'value' => self::$trattamento_foto_titolo_default, 'display_name' => 'Titolo consenso trattamento di fotografie e video', 'type' => 'text', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_TRATTAMENTO_FOTO_TESTO', 'config' => 'app.privacy.trattamento_foto.testo', 'value' => self::$trattamento_foto_testo_default, 'display_name' => 'Testo consenso trattamento di fotografie e video', 'type' => 'textarea', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_TRATTAMENTO_FOTO_MOSTRA_ISCRIZIONE', 'config' => 'app.privacy.trattamento_foto.iscrizione.mostra', 'value' => '', 'display_name' => 'Mostra Informativa e consenso al trattamento di fotografie e video in fase d\'iscrizione', 'type' => 'boolean', 'group' => 'GDPR'],
    ['key' => 'PRIVACY_TRATTAMENTO_FOTO_OBBLIGATORIO_ISCRIZIONE', 'config' => 'app.privacy.trattamento_foto.iscrizione.obbligatorio', 'value' => '', 'display_name' => 'Accettazione Informativa al trattamento di fotografie e video vincolante per l\'iscrizione agli eventi', 'type' => 'boolean', 'group' => 'GDPR'],

    ['key' => 'PRIVACY_POLICY_NOME_PARROCCHIA', 'config' => 'app.privacy_policy.nome_parrocchia', 'value' => '', 'display_name' => 'Nome parrocchia nella privacy policy', 'type' => 'text', 'group' => 'Privacy Policy'],
    ['key' => 'PRIVACY_POLICY_INDIRIZZO_PARROCCHIA', 'config' => 'app.privacy_policy.indirizzo_parrocchia', 'value' => '', 'display_name' => 'Indirizzo parrocchia nella privacy policy', 'type' => 'text', 'group' => 'Privacy Policy'],
    ['key' => 'PRIVACY_POLICY_EMAIL_PARROCCHIA', 'config' => 'app.privacy_policy.email_parrocchia', 'value' => '', 'display_name' => 'Indirizzo email parrocchia nella privacy policy', 'type' => 'text', 'group' => 'Privacy Policy'],
  ];
}

public static function render($string, $data)
  {
      $php = Blade::compileString($string);

      $obLevel = ob_get_level();
      ob_start();
      extract($data, EXTR_SKIP);

      try {
          eval('?' . '>' . $php);
      } catch (Exception $e) {
          while (ob_get_level() > $obLevel) ob_end_clean();
          throw $e;
      } catch (Throwable $e) {
          while (ob_get_level() > $obLevel) ob_end_clean();
          throw new FatalThrowableError($e);
      }

      return ob_get_clean();
  }


}

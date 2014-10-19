<?php echo get_core_vars( 'lmenu' );?>
<section id="content">
<section class="bigwrapper"><?php echo get_core_vars( 'inner_head' );?>
  
  <section class="scrollable" id="pjax-container">
    <header>
      <div class="row b-b m-l-none m-r-none">
        <div class="col-sm-4">
          <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
          <p class="block text-muted"><?php echo get_page('description');?></p>
        </div>
      </div>
    </header>
    <section class="scrollable wrapper"> 
      <!-- data-toggle="tooltip" data-placement="right" title="" data-original-title="Statistiques sur le traffic de votre site." -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel">
            <div class="panel-body">
              <h1 class="smb smh">Vos premiers pas sur <?php echo get('core_version');?></h1>
              <br/>
              <div class="row">
                <div class="col-lg-2"> <img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_1.JPG');?>" /> </div>
                <div class="col-lg-10">
                  <h2 style="margin-top:0">Introduction</h2>
                  <p>Bienvenue dans ce guide du d&eacute;butant, vous apprendrez ici quels sont les fonctionnalit&eacute;s de Tendoo, mais aussi comment en faire bon usage.</p>
                  <p>L'ensemble des fonctionnalit&eacute;s sont disponibles sur la gauche de votre &eacute;cran, o&ugrave; se trouve le menu principal de votre espace administration Tendoo, ce dernier peut être &eacute;tendue par des modules. <br/>
                    Tous les diff&eacute;rents liens vers les fonctionnalit&eacute;s les plus importantes sont affich&eacute;s. Vous pourrez par cons&eacute;quent :</p>
                  <ul>
                    <li>Cr&eacute;er des contr&ocirc;leurs</li>
                    <li>Installer des applications
                      <ul>
                        <li>G&eacute;rer les modules</li>
                        <li>G&eacute;rer les th&egrave;mes</li>
                      </ul>
                    </li>
                    <li>G&eacute;rer les param&egrave;tres</li>
                    <li>G&eacute;rer le syst&egrave;me</li>
                    <li>Revenir vers le site</li>
                  </ul>
                  <br>
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-body">
              <h2 class="smh">I - Les contr&ocirc;leurs</h2>
              <div class="row">
                <div class="col-lg-5"> <img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_2.JPG');?>" />
                  <hr class="line line-dashed" />
                  <img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_3.JPG');?>" /> </div>
                <div class="col-lg-7">
                  <p>Un contr&ocirc;leur est une adresse que vous rendez disponible sur le site. Cette adresse s'appuie sur l'adresse de base et ajoute le code du contr&ocirc;leur que vous avez sp&eacute;cifi&eacute;.</p>
                  <p>G&eacute;n&eacute;ralement les contr&ocirc;leurs permettent de rendre disponible une fonctionnalit&eacute; depuis une adresse donn&eacute;e. Ainsi pour cr&eacute;er un blog, l'on a souvent tendance &agrave; cr&eacute;er un contr&ocirc;leur ayant pour code "blog" et pour module affect&eacute; "Blogster - Le gestionnaire d'articles".
                  <p>
                  <p>Vous avez la possibilit&eacute; de d&eacute;finir le titre de la page, la description de la page, de choisir si le contr&ocirc;leur doit s'afficher &agrave; la racine du menu principale (emplacement du contr&ocirc;leur) o&ugrave; sous un autre contr&ocirc;leur dont il sera enfant, de choisir qu'en cliquant sur le contr&ocirc;leur vous &ecirc;tes plut&ocirc;t redirig&eacute; vers un lien que vous avez sp&eacute;cifi&eacute; (Lien vers une page), de rendre le menu visible dans le menu principal (Visibilit&eacute; de la page), d'affecter un module (fonctionnalit&eacute; ex&eacute;cut&eacute;e dans le contr&ocirc;leur), et de d&eacute;finir le contr&ocirc;leur comme principal, de telle sorte que lorsque l'on acc&egrave;de &agrave; http://www.monsite.com/ par exemple, la page ouverte en index (premier) sera le contr&ocirc;leur d&eacute;fini comme principal.</p>
                  <p><a href="<?php echo $this->instance->url->site_url(array('admin','pages','create'));?>"><strong>Cr&eacute;ez un nouveau contr&ocirc;leur maintenant</strong></a>, dans cette page vous retrouverez plus d'informations dans la cr&eacute;ation des contr&ocirc;leurs.</p>
                  <p><?php echo tendoo_warning('Si le module affect&eacute; n\'est pas activ&eacute;, alors il ne pourra pas s\'executer et la page affichera une erreur');?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-body">
              <h2 class="smb smh" id="tendooFonction">II - Installer une application Tendoo</h2>
              <br />
              <div class="row">
                <div class="col-lg-8">
                  <p>Afin d'&eacute;tendre les fonctionnalit&eacute;s de Tendoo, il est n&eacute;cessaire d'installer des applications Tendoo. Les applications Tendoo sont de deux types. D'une part, nous avons les <strong>modules</strong> et d'autre part, nous avons les <strong>th&egrave;mes</strong>.</p>
                  <p>Les applications peuvent &ecirc;tres install&eacute;s de plusieurs façons. Vous pouvez, soit envoyer votre fichier zip directement via l'interface d'envoi (upload), ou vous pouvez &eacute;galement installer une application avec un lien via dans la section "<strong>Depuis une URL</strong>". Ici deux possibilit&eacute;s vous sont offertes. Si l'application provient d'une plateforme tels que <strong><a href="https://www.github.com/">Github</a></strong>, alors vous devez choisir l'option "<strong>Utiliser le dossier de la racine</strong>", car les fichiers provenant de <strong><a href="https://www.github.com/">Github</a></strong>, en plus d'&ecirc;tre compress&eacute;, sont compris dans un dossier, lorsque vous choisissez cette option, c'est le premier dossier de la racine qui sera utilis&eacute; comme r&eacute;pertoire de l'application. Dans le cas contraire, si le fichier zip contient toute l'application, alors utilisez le proc&eacute;d&eacute; "<strong>Normal</strong>".</p>
                  <p>Les applications ont un acc&egrave;s privil&eacute;gi&eacute; aux ressources du syst&egrave;me. Par cons&eacute;quent, une application t&eacute;l&eacute;charg&eacute;e depuis en emplacement non agr&eacute;e, peut endommager votre site. La plateforme Tendoo examine les applications qui sont envoy&eacute;es et les valides lorsque ces derniers respectent les normes de conception d'application impos&eacute;es.</p>
                  <p><?php echo tendoo_warning('Toutes les applications ne seront pas compatible avec votre version de Tendoo, assurez vous que la version requise pour ex&eacute;cuter l\'application est identique &agrave; votre version actuelle de Tendoo.');?></p>
                </div>
                <div class="col-lg-4"> <img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_4.JPG');?>" /> </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-body">
              <h2 class="smb smh" id="tendooFonction">II - a : G&eacute;rer les modules <small><a href="<?php echo $this->instance->url->site_url(array('admin','modules'));?>"><i class="fa fa-link"></i></a></small></h2>
              <br />
              <div class="row">
                <div class="col-lg-6">
                  <p>Losque les modules sont install&eacute;s, ils sont tous disponible dans cette interface.</p>
                  <p>Dans cette section, vous pouvez voir tous les modules install&eacute;s, vous assurez qu'ils sont activ&eacute;s, mais aussi les d&eacute;sinstaller. En cliquant sur le nom ou l'icone, vous acc&egrave;derez &agrave; l'interface embarqu&eacute;e du module. Si ce dernier ne contient aucune interface embarqu&eacute;e, Tendoo g&eacute;n&egrave;rera une erreur.</p>
                  <p>Il existe deux types de modules, les modules de type <strong>Global</strong> et les modules de type <strong>Unique</strong>. La différence entre les deux est que le premier type s'exécute dans tous les contrôleurs du site, alors que les autres s'ex&eacute;cute uniquement dans les contr&ocirc;leurs o&ugrave; ils sont appel&eacute;s.</p>
                  <p>Un module ne peut pas &ecirc;tre &agrave; la fois <strong>Unique</strong> et <strong>Global</strong>. Lorsqu'un module est d&eacute;sactiv&eacute;, vous pouvez toujours l'utiliser, mais son utilisation n'aura aucune incidence sur le site, notez que chaque fois que vous tenterez d'acc&eacute;der &agrave; un contr&ocirc;leur dont le module est d&eacute;sactivez, Tendoo g&eacute;n&egrave;rera &eacute;galement une erreur.</p>
                </div>
                <div class="col-lg-6"> <img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_5.JPG');?>" /> </div>
              </div>
              <h2 id="tendooFonction">II - a - 1 : Effectuer une publication dans le blog</h2>
              <p>Pour effectuer une publication, vous devez vous assurez que le module "Blogster - Gestionnaire d'articles" est correctement install&eacute; et activ&eacute;. Maintenant assurez-vous qu'un contr&ocirc;leur contient comme module attach&eacute; "Blogster  - Gestionnaire d'articles" et gardez en mémoire le code du contr&ocirc;leur. Par d&eacute;faut, Tendoo cr&eacute;e deux contr&ocirc;leurs un contr&ocirc;leur avec le nom de code "blog" et l'autre avec nom de code "home". Si ce n'est pas le cas chez vous, alors vous avez la possibilit&eacute; d'en cr&eacute;er.</p>
              <p>Apr&egrave;s la cr&eacute;ation d'un contr&ocirc;leur, celui-ci est d&eacute;sormais disponible sur le menu principal (Si vous l'avez rendu visible bien s&ucirc;r).</p>
              <p>Pour effectuer votre premi&egrave;re publication acc&eacute;dez &agrave; l'interface du module "Blogster..." en cliquant sur l'icone ou le nom.</p>
              <div class="row">
                <div class="col-lg-6"> <img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_6.JPG');?>" /> </div>
                <div class="col-lg-6">
                  <p>Lorsque vous cliquez sur l'icone ou sur le nom du module, vous accédez &agrave; un nouvel emplacement, et un &eacute;l&eacute;ment s'ajoute au menu principal de gauche comme dans l'image qui pr&eacute;c&egrave;de. Le nouveau menu est intitul&eacute; <strong>Blogster</strong>. Lorsque le curseur se mets dessus, vous pouvez voir de nouveaux liens s'afficher. Ces liens donne l'acc&egrave;s &agrave; de nouvelles fonctionnalit&eacute;s. Cliquez sur "Cr&eacute;er un article" pour cr&eacute;er votre premier article.</p>
                  <p>Dans la param&egrave;tres avanc&eacute;s, vous pouvez modifier l'accessibilit&eacute;, soit en autorisant ou non les utilisateurs non inscrit &agrave; faire des commentaires, soit en permettant qu'une examination des commentaires soit effectu&eacute;e avant qu'ils ne soient publi&eacute;s. 
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-lg-3">
                  <p>Voici l'interface de cr&eacute;ation d'article. Entrez les informations correspondantes dans les champs présents. Choisissez une image aperçu et une image taille r&eacute;elle pour votre article et publiez la. Lorsque vous avez publi&eacute; un article, une notification s'affichera en haut, identique à celle-ci</p>
                  <p><?php echo notice('done');?></p>
                  <p>Dès maintenant vous pouvez acc&eacute;dez &agrave; l'espace utilisateur de votre site et voir votre publication, dans le contr&ocirc;leur qui contient comme module attach&eacute; "Blogster...".</p>
                </div>
                <div class="col-lg-9"> <img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_7.JPG');?>" /> </div>
              </div>
              <br />
              <h2 id="tendooFonction">II - a - 2 : G&eacute;rer les cat&eacute;gories</h2>
              <div class="row">
              	<div class="col-lg-3">
                	<img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_8.JPG');?>" />
                    <hr class="line line-dashed" />
                    <img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_9.JPG');?>" />
                </div>
                <div class="col-lg-9">
                	<p>Vous pouvez avoir besoin de classer chacune de vos publications, c'est la raison d'être des catégories. En effet supposons que vous soyez un prestataire de service spécialisé dans les assurances, vous voudrez par exemple classer vos actualités en fonction des différents types de contrats d'assurance, c'est donc ainsi dans le souci d'organisation que vous créerez une catégorie "Assurance Vie" ou "Assurance Maladie".</p>
                    <p>Vous pouvez administrer les cat&eacute;gories depuis l'interface de gestion des catégories. Vous avez le droit de cr&eacute;er autant de cat&eacute;gorie que vous désirez.</p>
                    <p>Cependant la suppression d'une cat&eacute;gorie ne peut &ecirc;tre faite si des articles y sont toujours attach&eacute;. Il vous faudra changer les cat&eacute;gories de chaque articles.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-body">
              <h2 class="smh" id="tendooFonction">III  : G&eacute;rer les th&egrave;mes <small><a href="<?php echo $this->instance->url->site_url(array('admin','themes'));?>"><i class="fa fa-link"></i></a></small></h2>
				<p>Avec les thèmes vous ferez la différence entre votre site web et d'autres. Les thèmes s'installent comme les modules, c'est à dire, via la même interface et sous la même forme. Tendoo effectue un contrôl sur l'application envoyé afin de déterminer s'il s'agit d'un th&egrave;me ou d'un module.</p>
                <div class="row">
                <div class="col-lg-6">
                	<img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_10.JPG');?>" />
                </div>
                <div class="col-lg-6">
                	<img style="width:100%;" src="<?php echo $this->instance->url->img_url('discover/first_step_11.JPG');?>" />
                </div>
                <div class="col-lg-12">
                	<p>Depuis ces interfaces, vous pouvez accéder à l'interface embarquée du thème en cliquant sur le nom du thème. Si le thème n'en possède pas, un avertissement sera généré par Tendoo. Vous pourrez cependant accéder aux réglages avanc&eacute;s, dans lesqules vous pourrez soit activer un thème comme thème par défaut, soit désinstaller un thème.</p>
                    <p>La désinstallation d'un thème suppose la suppression de tous les fichiers liées à ce thèmes, ainsi que les tables et autres contenu liées à la base de données crées durant son installation. Cette opération est irreversible.</p>
                    <p>Pour avoir plus d'information sur l'utilisation de tendoo, connectez-vous sur <a href="http://tendoo.tk/">Tendoo - Blog d'evaluation officiel</a>.</p>
                </div>
                </div>
			</div>
			</div>
        </div>
      </div>
      </div>
    </section>
  </section>
</section>

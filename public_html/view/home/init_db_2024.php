<?php

declare(strict_types=1);

use app\core\entity\Department;
use app\core\entity\Gender;
use app\core\entity\Grade;
use app\core\entity\Profile;
use app\core\entity\Publication;
use app\core\entity\Section;
use app\core\entity\Status;
use app\core\entity\Subject;
use app\core\entity\User;
use app\core\entity\WhoAmI;
use app\core\model\Model;
use app\core\model\ProfileModel;
use app\core\model\PublicationModel;

class InitializationDB extends Model {

    public function setSingle(string $table, array $contents=[]) : void {
        echo "=== InitializationDB::setSingle(". $table .")<br>";
        
        $sql = "INSERT INTO " . $table . "(content) VALUES(:content)";

        foreach($contents as $content) {
            $params = [
                [":content", $content, PDO::PARAM_STR]
            ];
            $this->query($sql, $params)->execute();
        }
    }

    public function setUsers(array $users, $table="users") {
        echo "=== InitializationDB::setUsers(". $table .")<br>";

        $sql = "INSERT INTO users(first_name, last_name, gender_id, 
        email, phone, department_id, whoami_id, section_id, grade_id,
        user_name, pwd) VALUES(:first_name, :last_name, :gender_id, 
        :email, :phone, :department_id, :whoami_id, :section_id, :grade_id,
        :user_name, :pwd)";

        foreach($users as $user) {
            $params = [
                [":first_name", $user->getFirstName(), PDO::PARAM_STR],
                [":last_name", $user->getLastName(), PDO::PARAM_STR],
                [":gender_id", $user->getGender()->value, PDO::PARAM_INT],
                [":email", $user->getEmail(), PDO::PARAM_STR],
                [":phone", $user->getPhone(), PDO::PARAM_STR],
                [":department_id", $user->getDepartment()->value, PDO::PARAM_INT],
                [":whoami_id", $user->getWhoAmI()->value, PDO::PARAM_INT],
                [":section_id", $user->getSection()->value, PDO::PARAM_INT],
                [":grade_id", $user->getGrade()->value, PDO::PARAM_INT],
                [":user_name", $user->getUserName(), PDO::PARAM_STR],
                [":pwd", $this->getEncryptedPwd($user->getPwd()), PDO::PARAM_STR]
            ];
            $this->query($sql, $params)->execute();

            if($user->getWhoAmI() == WhoAmI::PROFESSOR) {
                $this->setPublications($user);
            }
        }
    }

    public function setSubjects(array $subjects=[], string $table="subjects") : void {
        echo "=== InitializationDB::setSubjects(". $table .")<br>";
        
        $sql = "INSERT INTO ". $table ."(name, section_id, grade_id, user_name, max_note, coef) VALUES(:name, :section_id, :grade_id, :user_name, :max_note, :coef)";

        foreach($subjects as $subject) {
            $params = [
                [":name", $subject->getName(), PDO::PARAM_STR],
                [":section_id", $subject->getSection()->value, PDO::PARAM_INT],
                [":grade_id", $subject->getGrade()->value, PDO::PARAM_INT],
                [":user_name", $subject->getUserName(), PDO::PARAM_STR],
                [":max_note", $subject->getMaxNote(), PDO::PARAM_STR],
                [":coef", $subject->getCoef(), PDO::PARAM_STR]
            ];
            $this->query($sql, $params)->execute();
        }
    }

    public function setProfiles(array $profiles=[], string $table="profiles") : void {
        echo "=== InitializationDB::setProfiles(". $table .")<br>";

        $profileModel = (new ProfileModel)->setTable($table);
        
        foreach($profiles as $profile) {
            $profileModel->add($profile);
        }
    }

    public function setForumSubjects(array $forums=[], string $table="forum_subjects") : void {
        echo "=== InitializationDB::setForumSubjects(". $table .")<br>";
        
        $sql = "INSERT INTO forum_subjects(content, term_id) VALUES(:content, :term_id)";

        foreach($forums as $forum) {
            $params = [
                [":content", $forum['content'], PDO::PARAM_STR],
                [":term_id", $forum['term_id'], PDO::PARAM_INT]
            ];
            $this->query($sql, $params)->execute();
        }
    }

    public function setForumMsgs(array $msgs=[], string $table="forum_msgs") : void {
        echo "=== InitializationDB::setForumMsgs(". $table .")<br>";
        
        $sql = "INSERT INTO forum_msgs(user_name, forum_subject_id, content) VALUES(:user_name, :forum_subject_id, :content)";

        foreach($msgs as $msg) {
            $params = [
                [":user_name", $msg['user_name'], PDO::PARAM_STR],
                [":forum_subject_id", $msg['forum_subject_id'], PDO::PARAM_INT],
                [":content", $msg['content'], PDO::PARAM_STR]
            ];
            $this->query($sql, $params)->execute();
        }
    }

    private function setPublications(User $user, string $table="publications") {
        echo "=== InitializationDB::setPublications(". $table .")<br>";
        
        $user_name = $user->getUserName();        
        $file_path = "data/publications/" . $user_name . ".txt";

        $stream = fopen($file_path, "r");
        if($stream == null) return;

        while(!feof($stream)) {
            $citeAs = fgets($stream);
            $doi = fgets($stream);
            $year = fgets($stream);

            if ($citeAs != null && $doi != null && $year != null) {
                (new PublicationModel)->add(
                    new Publication(
                        0,
                        $user_name,
                        $citeAs,
                        $doi,
                        $year,
                        new DateTime(),
                        false
                    )
                );
            }            
        }

        fclose($stream);
    }
}

echo "=== importing data ...<br>";

// instance of the class
$initializationDB = new InitializationDB;

// genders table
$initializationDB->setSingle("genders", [
    "Masculin", "Féminin"
]);

// departments table
$initializationDB->setSingle("departments", [
    "Ouest", "Sud-Est", "Nord", "Nord-Est",
    "Artibonite", "Centre", "Sud", "Grand'Anse",
    "Nord-Ouest", "Nippes"
]);

// table whoami
$initializationDB->setSingle("whoami", [
    "Etudiant", "Professeur", "Secretary", "Adm"
]);

// table sections
$initializationDB->setSingle("sections", [
    "Physique", "Mathématiques", "Philosophie",
    "Sciences naturelles", "Lettres modernes",
    "Langues vivantes", "Histoire & Géographie"
]);

// table grades
$initializationDB->setSingle("grades", [
    "Préparatoire", "L1", "L2",
    "L3", "M1", "M2", "PhD"
]);

// table statuses
$initializationDB->setSingle("statuses", [
    "Demande en cours", "Validé", "Connecté",
    "Déconnecté", "Actif", "Inactif", "Online",
    "Offline", "Suspendu"
]);

// table messages
$initializationDB->setSingle("messages", [
    "Ok", "Désolé mais vous n'avez pas accès à la page demandée.",
    "La page que vous demandez n'existe pas.",
    "Cet email a déjà été utilisé.",
    "Ce numéro de téléphone a déjà été utilisé.",
    "Cet identifiant a déjà été utilisé.",
    "Votre compte n'est pas encore actif. Veuillez contacter les responsables.",
    "Vous êtes déjà connecté(e) sur un autre appareil/navigateur. Veuillez d'abord vous déconnecter.",
    "Vous êtes inatif(ve) trop lontemps. Veuillez d'abord vous reconnecter.",
    "Votre compte a été suspendu. Veuillez contacter les responsables.",
    "Vos informations (identifiant/mot de passe) n'existent pas dans le système.",
    "Fichier trop long.",
    "Téléversement du fichier échoué."
]);

// table sessions
$initializationDB->setSingle("sessions", [
    "Trimestre 1", "Trimestre 2", "Trimestre 3"
]);

// table forum_terms
$initializationDB->setSingle("forum_terms", [
    "Technologie et sciences", "Politique et économie",
    "Culture et médias", "Histoire et événements passés",
    "Sports", "Psychologie et philosophie",
    "Vie quotidienne et entraide"
]);

// table note_status
$initializationDB->setSingle("notes_status", [
    "Ajoutée", "Modifiée", "Confirmée", "Validée"
]);

// table users
$initializationDB->setUsers([
    new User(
        0, "Dieuseul", "Prédélus", Gender::MALE, "adm@ensueh.com",
        "+1234567890", Department::NordOuest,
        WhoAmI::ADM, Section::PHYSICS,
        Grade::PHD, "adm", "Adm@ENS2024",
        new DateTime(), null,
        Status::VALIDATED, new DateTime()
    ),
    new User(
        0, "Dieuseul", "Prédélus", Gender::MALE, "dpredelus@ensueh.com",
        "+509 48 95 78 08", Department::NordOuest,
        WhoAmI::PROFESSOR, Section::PHYSICS,
        Grade::PHD, "dpredelus", "DPredelus@ENS2024",
        new DateTime(), null,
        Status::VALIDATED, new DateTime()
    ),
    new User(
        0, "Rubenson", "Mareus", Gender::MALE, "rmareus@ensueh.com",
        "+33 7 52 24 63 11", Department::NordOuest,
        WhoAmI::PROFESSOR, Section::PHYSICS,
        Grade::PHD, "rmareus", "RMareus@ENS2024",
        new DateTime(), null,
        Status::VALIDATED, new DateTime()
    ),
    new User(
        0, "Kinson", "Vernet", Gender::MALE, "kvernet@ensueh.com",
        "+33 7 49 55 56 74", Department::Ouest,
        WhoAmI::PROFESSOR, Section::PHYSICS,
        Grade::PHD, "kvernet", "KVernet@ENS2024",
        new DateTime(), null,
        Status::VALIDATED, new DateTime()
    ),
    new User(
        0, "Linda", "Etienne", Gender::MALE, "secretaire@ensueh.com",
        "+509 41 76 54 98", Department::Artibonite,
        WhoAmI::SECRETARY, Section::PHYSICS,
        Grade::M2, "secretaire", "LEtienne@ENS2024",
        new DateTime(), null,
        Status::VALIDATED, new DateTime()
    ),
    new User(
        0, "Judel", "Dort", Gender::MALE, "jdort@ensueh.com",
        "+509 56 85 34 25", Department::Ouest,
        WhoAmI::STUDENT, Section::PHYSICS,
        Grade::L0, "jdort", "JDort@ENS2024",
        new DateTime(), null,
        Status::VALIDATED, new DateTime()
    ),
    new User(
        0, "Nathalie", "Pierre", Gender::FEMALE, "npierre@ensueh.com",
        "+509 45 87 22 51", Department::GrandAnse,
        WhoAmI::STUDENT, Section::PHYSICS,
        Grade::L0, "npierre", "NPierre@ENS2024",
        new DateTime(), null,
        Status::VALIDATED, new DateTime()
    ),
    new User(
        0, "Saul", "Maddy", Gender::MALE, "smaddy@ensueh.com",
        "+509 71 56 23 09", Department::Artibonite,
        WhoAmI::STUDENT, Section::PHYSICS,
        Grade::L0, "smaddy", "SMaddy@ENS2024",
        new DateTime(), null,
        Status::REQUESTED, new DateTime()
    ),
    new User(
        0, "Robenson", "Dupont", Gender::MALE, "rdupont@ensueh.com",
        "+509 77 69 11 28", Department::SudEst,
        WhoAmI::STUDENT, Section::PHYSICS,
        Grade::L1, "rdupont", "RDupont@ENS2024",
        new DateTime(), null,
        Status::VALIDATED, new DateTime()
    ),
    new User(
        0, "Julienne", "Faustin", Gender::FEMALE, "jfaustin@ensueh.com",
        "+509 44 67 00 87", Department::SudEst,
        WhoAmI::STUDENT, Section::PHYSICS,
        Grade::L1, "jfautin", "JFaustin@ENS2024",
        new DateTime(), null,
        Status::REQUESTED, new DateTime()
    ),
    new User(
        0, "Smith", "Antoine", Gender::MALE, "santoine@ensueh.com",
        "+509 34 77 30 07", Department::Sud,
        WhoAmI::STUDENT, Section::PHYSICS,
        Grade::M1, "santoine", "SAntoine@ENS2024",
        new DateTime(), null,
        Status::REQUESTED, new DateTime()
    ),
    new User(
        0, "Katiana", "Jean", Gender::MALE, "kjean@ensueh.com",
        "+509 66 71 00 45", Department::Nord,
        WhoAmI::STUDENT, Section::PHYSICS,
        Grade::M1, "kjean", "KJean@ENS2024",
        new DateTime(), null,
        Status::REQUESTED, new DateTime()
    ),
]);

// table subjects
$initializationDB->setSubjects([
    // LO
    new Subject(
        0, "Cinématique",
        Section::PHYSICS, Grade::L0,
        "rmareus", 100.0, 1.0,
        new DateTime(), false
    ),
    new Subject(
        0, "Mécanique du point",
        Section::PHYSICS, Grade::L0,
        "kvernet", 100.0, 1.0,
        new DateTime(), false
    ),
    new Subject(
        0, "Anglais",
        Section::PHYSICS, Grade::L0,
        "rmareus", 100.0, 1.0,
        new DateTime(), false
    ),
    new Subject(
        0, "Chimie",
        Section::PHYSICS, Grade::L0,
        "kvernet", 100.0, 1.0,
        new DateTime(), false
    ),
    new Subject(
        0, "Dynamique Newtonienne",
        Section::PHYSICS, Grade::L0,
        "rmareus", 100.0, 1.0,
        new DateTime(), false
    ),
    // L1
    new Subject(
        0, "Electromagnétisme",
        Section::PHYSICS, Grade::L1,
        "rmareus", 100.0, 1.0,
        new DateTime(), false
    ),
    // M1
    new Subject(
        0, "Mécanique Quantique",
        Section::PHYSICS, Grade::M1,
        "rmareus", 100.0, 10.,
        new DateTime(), false
    ),
    new Subject(
        0, "Physique Atomique",
        Section::PHYSICS, Grade::M1,
        "dpredelus", 100.0, 9.,
        new DateTime(), false
    ),
    new Subject(
        0, "Physique Statistique",
        Section::PHYSICS, Grade::M1,
        "dpredelus", 100.0, 10.,
        new DateTime(), false
    ),
    new Subject(
        0, "Optique & Laser",
        Section::PHYSICS, Grade::M1,
        "rmareus", 100.0, 9.,
        new DateTime(), false
    ),
    new Subject(
        0, "Physique Nucléaire",
        Section::PHYSICS, Grade::M1,
        "dpredelus", 100.0, 8.,
        new DateTime(), false
    ),
    new Subject(
        0, "Programmation",
        Section::PHYSICS, Grade::M1,
        "kvernet", 100.0, 4.,
        new DateTime(), false
    ),
    new Subject(
        0, "Chimie de l'Environnement",
        Section::PHYSICS, Grade::M1,
        "kvernet", 100.0, 6.,
        new DateTime(), false
    ),
    new Subject(
        0, "Micro-projet",
        Section::PHYSICS, Grade::M1,
        "rmareus", 100.0, 4.,
        new DateTime(), false
    ),
]);

// table profiles
$initializationDB->setProfiles([
    new Profile(
        0, "dpredelus", "Dieuseul", "Prédélus",
        "dpredelus.png",
        "Dr Dieuseul PREDELUS, Enseignant-Chercheur de l'Université d'Etat d'Haïti, spécialiste en physique atomique et moléculaire, affecté au département de Physique de l'Ecole Normale Supérieure (ENS) et membre du Laboratoire des Sciences pour l'Environnement et l'Energie. J'ai obtenu mes diplômes de master de Physique et de Doctorat à l'Université Claude Bernard Lyon1. Je suis actuellement Responsable du master de physique atome, molécule, énergie et environnement de l'ENS et Responsable de l'axe <b>Energies Alternatives</b> du laboratoire LS2E.",
        "Mes activités de recherche tournent autour de différents champs tels que le transfert des nanoparticules dans les zones non saturées et le photovoltaïque.",
        "dpredelus@ensueh@com",
        new DateTime(),
        false
    ),
    new Profile(
        0, "rmareus", "Rubenson", "Mareus",
        "rmareus.png",
        "Dr Rubenson MAREUS, ...",
        "",
        "rmareus@ensueh.com",
        new DateTime(),
        false
    ),
    new Profile(
        0, "kvernet", "Kinson", "Vernet",
        "kvernet.png",
        "Dr Kinson VERNET, est spécialiste en Physique des Particules. Ses travaux de recherche se portent sur la radiographie des volcans. Il cherche à dévélopper des outils et méthodes robustes permettant de radiographier un volcan en utilisant la mesure des muons atmosphériques qui se propagent à travers le volcan. Cette technique d'imagerie a été utilsée dans le passé par d'autres chercheurs dans divers secteurs tels que le génie civil, les pyramides, les centrales nucléaires, etc.",
        "",
        "kvernet@ensueh.com",
        new DateTime(),
        false
    ),
    /*
    new Profile(
        0, "wfidel", "Wisly", "Fidel",
        "wfidel.png",
        "Wisly FIDEL, enseignant-chercheur à l'ENS et doctorant en énergies renouvelables propres et alternatives. Il est ingénieur reconnu par la CTI et légalement enregistré dans le Répertoire des Ingénieurs et des Scientifiques Français. Il a obtenu son master de physique, mention \"Atome, Molécule, Energie et Environnement\" à l'ENS, en partenariat avec les universités de Poitiers et Claude Bernard Lyon 1 . Il est ingénieur diplômé de la grande école JUNIA-Hautes Etudes d'Ingénieur(HEI) de l'Université Catholique de Lille dans le domaine des énergies et systèmes électriques automatisés.",
        "Ses travaux de recherche, menés au sein des laboratoires CEMHTI du CNRS à Orléans et LS2E de l'ENS, se concentrent sur l'optimisation des performances des cellules solaires à base de pérovskite et l'optimisation des systèmes énergétiques complexes.",
        "wfidel@ensueh.com; 0751486866",
        new DateTime(),
        true
    )
    */
]);

// table forum_subjects
$initializationDB->setForumSubjects([
    [
        "content" => "L'intelligence artificielle est-elle une menace pour les humains ?", 
        "term_id" => 1
    ],
    [
        "content" => "La désextinction, qui consiste à ramener des espèces éteintes à la vie, vaut-elle le coût ?", 
        "term_id" => 1
    ],
    [
        "content" => "Devrions-nous dépendre davantage des énergies renouvelables (comme l'énergie solaire et éolienne) ou continuer à utiliser les combustibles fossiles?", 
        "term_id" => 1
    ],
    [
        "content" => "Comment les avancées technologiques récentes dans les domaines tels que l'automobile, la domotique et la robotique affectent-elles notre vie quotidienne ?", 
        "term_id" => 1
    ],
    [
        "content" => "Comment les solutions techniques spécifiques, comme les mécanismes de stationnement automatique, les éoliennes ou la ventilation autonome pour les vérandas améliorent-elles notre qualité de vie ?", 
        "term_id" => 1
    ],
    [
        "content" => "L'intelligence artificielle est-elle une menace pour les humains ?", 
        "term_id" => 1
    ],
    [
        "content" => "Guerre israélo-palestinienne suite", 
        "term_id" => 2
    ],
    [
        "content" => "Procès de Donald Trump", 
        "term_id" => 2
    ]
]);

// table forum_msgs
$initializationDB->setForumMsgs([
    [
        "user_name" => "kvernet",
        "forum_subject_id" => 1,
        "content" => "L'intelligence artificielle (IA) suscite des débats passionnés concernant ses risques et ses avantages. Voici un aperçu des points de vue sur cette question : Obsolescence de l'emploi : L'IA générative, capable de produire du texte, des images et des sons sur simple commande en langage courant, soulève la question de l'obsolescence de certains emplois. Jusqu'à 30 % des heures actuellement travaillées dans l'économie américaine pourraient être automatisées d'ici 2030, ce qui pourrait affecter diverses professions, du personnel administratif aux médecins en passant par les journalistes1. Droits d'auteur : Les artistes ont protesté contre des logiciels tels que DALL-E d'OpenAI ou Midjourney, qui génèrent des images sur demande. Certains artistes reprochent aux entreprises d'avoir utilisé leurs œuvres sans permission ni rémunération. Les IA génératives sont basées sur des modèles de langage qui nécessitent d'énormes quantités de données récupérées en ligne1. Risques pour les droits humains : Michelle Bachelet, la Haut-Commissaire des droits de l'homme de l'ONU, a souligné que les technologies d'IA peuvent avoir des effets négatifs sur les droits humains si elles ne sont pas utilisées avec précaution2. Risque existentiel : Des experts en IA ont averti que la technologie qu'ils développent pourrait un jour constituer une menace existentielle pour l'humanité, comparable aux pandémies et à la guerre nucléaire3. En fin de compte, l'IA peut être à la fois bénéfique et risquée. Il est essentiel de mettre en place des régulations et des mesures de sécurité pour maximiser les avantages tout en minimisant les dangers potentiels."
    ]
]);

echo "=== importing data done !<br>";
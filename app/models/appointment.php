<?php

class Appointment {
    private $db;

    // Le constructeur reçoit la connexion PDO depuis le contrôleur
    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // 1. FONCTION POUR VÉRIFIER LA DISPONIBILITÉ DU CRÉNEAU (Délai d'1h)
    public function isTimeSlotAvailable($datePrevue, $heurePrevue) {
        try {
            $timestampChoisi = strtotime("$datePrevue $heurePrevue");
            $debutFenetre = date('Y-m-d H:i:s', $timestampChoisi - 3600); // - 1 heure
            $finFenetre = date('Y-m-d H:i:s', $timestampChoisi + 3600);   // + 1 heure

            $sql = "SELECT COUNT(*) as total FROM appointments 
                    WHERE appointment_date = :date_jour 
                    AND status != 'cancelled' 
                    AND appointment_time BETWEEN :debut AND :fin";
                    
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'date_jour' => $datePrevue,
                'debut' => date('H:i:s', strtotime($debutFenetre)),
                'fin' => date('H:i:s', strtotime($finFenetre))
            ]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Retourne true si le créneau est libre (0 rendez-vous dans la tranche d'1h)
            return $result['total'] == 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification du créneau : " . $e->getMessage());
        }
    }

    // 2. FONCTION POUR INSERER UN RENDEZ-VOUS (UUID)
    public function createAppointment($id, $user_id, $service_id, $date, $time) {
        try {
            $stmt = $this->db->prepare("INSERT INTO appointments 
                (id, user_id, service_id, appointment_date, appointment_time, status, created_at) 
                VALUES (:id, :user_id, :service_id, :appointment_date, :appointment_time, 'pending', NOW())");
            
            return $stmt->execute([
                'id' => $id,
                'user_id' => $user_id, // Ton UUID d'utilisateur
                'service_id' => $service_id, 
                'appointment_date' => $date,
                'appointment_time' => $time
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'enregistrement du rendez-vous : " . $e->getMessage());
        }
    }

    // 3. FONCTION POUR RECOUPER LES RESERVATIONS D'UN CLIENT (Pour son Dashboard)
    public function getAppointmentsByUser($user_uuid) {
        try {
            $stmt = $this->db->prepare("SELECT a.*, s.name as service_name, s.price 
                                        FROM appointments a 
                                        JOIN services s ON a.service_id = s.id 
                                        WHERE a.user_id = :user_id 
                                        ORDER BY a.appointment_date DESC, a.appointment_time DESC");
            $stmt->execute(['user_id' => $user_uuid]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des rendez-vous : " . $e->getMessage());
        }
    }

    // ==========================================================
    // 4. METÒD AJOUTE YO (Pou koresponn ak pati Admin lan san erè)
    // ==========================================================

    // Rekipere TOUT randevou yo pou panel admin an (`admin/appointments`)
    public function getAllAppointments() {
        try {
            $stmt = $this->db->query("SELECT a.*, s.name as service_name, s.price, u.nom, u.prenom, u.email 
                                        FROM appointments a 
                                        LEFT JOIN services s ON a.service_id = s.id 
                                        LEFT JOIN users u ON a.user_id = u.id 
                                        ORDER BY a.appointment_date DESC, a.appointment_time DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de tous les rendez-vous : " . $e->getMessage());
        }
    }

    // Jwenn yon sèl randevou pa ID l (Itil pou resevwa, modifye oswa efase)
    public function getAppointmentById($id) {
        try {
            $stmt = $this->db->prepare("SELECT a.*, s.name as service_name, s.price, u.nom, u.prenom, u.email, u.telephone 
                                        FROM appointments a 
                                        LEFT JOIN services s ON a.service_id = s.id 
                                        LEFT JOIN users u ON a.user_id = u.id 
                                        WHERE a.id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du rendez-vous : " . $e->getMessage());
        }
    }

    // Efase yon randevou
    public function deleteAppointment($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM appointments WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du rendez-vous : " . $e->getMessage());
        }
    }
}
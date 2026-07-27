<?php

class Appointment {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function isTimeSlotAvailable($datePrevue, $heurePrevue) {
        try {
            $timestampChoisi = strtotime("$datePrevue $heurePrevue");
            $debutFenetre = date('Y-m-d H:i:s', $timestampChoisi - 3600);
            $finFenetre = date('Y-m-d H:i:s', $timestampChoisi + 3600);

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
            return $result['total'] == 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification du créneau : " . $e->getMessage());
        }
    }

    public function createAppointment($id, $user_id, $service_id, $date, $time) {
        try {
            $stmt = $this->db->prepare("INSERT INTO appointments 
                (id, user_id, service_id, appointment_date, appointment_time, status, created_at) 
                VALUES (:id, :user_id, :service_id, :appointment_date, :appointment_time, 'pending', NOW())");
            
            return $stmt->execute([
                'id' => $id,
                'user_id' => $user_id,
                'service_id' => $service_id,
                'appointment_date' => $date,
                'appointment_time' => $time
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'enregistrement du rendez-vous : " . $e->getMessage());
        }
    }

    public function getAppointmentsByUser($user_uuid) {
        try {
            $stmt = $this->db->prepare("SELECT a.*, s.name as service_name, s.price 
                                        FROM appointments a 
                                        LEFT JOIN services s ON a.service_id = s.id 
                                        WHERE a.user_id = :user_id 
                                        ORDER BY a.appointment_date DESC, a.appointment_time DESC");
            $stmt->execute(['user_id' => $user_uuid]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des rendez-vous : " . $e->getMessage());
        }
    }

    public function getAllAppointments() {
        try {
            // Utilisation directe des colonnes de la table appointments et liaison sécurisée avec users
            $stmt = $this->db->query("SELECT a.*, 
                                        COALESCE(s.name, a.service_nom) as service_name, 
                                        COALESCE(s.price, a.prix_total) as price, 
                                        CONCAT(u.firstname, ' ', u.lastname) as client_name, 
                                        u.email 
                                        FROM appointments a 
                                        LEFT JOIN services s ON a.service_id = s.id 
                                        LEFT JOIN users u ON a.user_id = u.id 
                                        ORDER BY a.appointment_date DESC, a.appointment_time DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de tous les rendez-vous : " . $e->getMessage());
        }
    }

    public function getAppointmentById($id) {
        try {
            $stmt = $this->db->prepare("SELECT a.*, 
                                        COALESCE(s.name, a.service_nom) as service_name, 
                                        COALESCE(s.price, a.prix_total) as price, 
                                        CONCAT(u.firstname, ' ', u.lastname) as client_name, 
                                        u.email 
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

    public function deleteAppointment($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM appointments WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du rendez-vous : " . $e->getMessage());
        }
    }
}
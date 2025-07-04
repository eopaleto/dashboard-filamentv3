DELIMITER $$

CREATE TRIGGER before_insert_sensor_kecepatan_aliran
BEFORE INSERT ON sensor_kecepatan_aliran
FOR EACH ROW
BEGIN
    IF NEW.kecepatan_aliran <= 3 THEN
        SET NEW.status = 'Lambat';
    ELSEIF NEW.kecepatan_aliran > 3 AND NEW.kecepatan_aliran <= 10 THEN
        SET NEW.status = 'Sedang';
    ELSE
        SET NEW.status = 'Cepat';
    END IF;
END$$

DELIMITER ;

------------------------------

-- Update data status: 'Jernih'
UPDATE sensor_kekeruhan_air
SET status = 'Jernih'
WHERE kekeruhan_air <= 5;

-- Update data status: 'Sedang'
UPDATE sensor_kekeruhan_air
SET status = 'Sedang'
WHERE kekeruhan_air > 5 AND kekeruhan_air <= 50;

-- Update data status: 'Keruh'
UPDATE sensor_kekeruhan_air
SET status = 'Keruh'
WHERE kekeruhan_air > 50;

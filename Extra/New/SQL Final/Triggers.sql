/*
=================================
 Workplace Details History Table
 =================================
*/

CREATE TRIGGER `before_insert_workplace_details_history` BEFORE INSERT ON `workplace_details_history`
 FOR EACH ROW BEGIN
    DECLARE v_ProCode VARCHAR(3);
    DECLARE v_DistrictCode VARCHAR(3);
    DECLARE v_ZoneCode VARCHAR(6);
    DECLARE v_DivisionCode VARCHAR(6);

    -- Fetch codes from institutions table
    SELECT ProCode, DistrictCode, ZoneCode, DivisionCode
    INTO v_ProCode, v_DistrictCode, v_ZoneCode, v_DivisionCode
    FROM institutions
    WHERE New_CenCode = NEW.selectedInstituteCode;

    -- Fetch names from province, district, zone, and division tables
    SELECT province INTO @Province FROM province WHERE procode = v_ProCode;
    SELECT distname INTO @District FROM district WHERE distcode = v_DistrictCode;
    SELECT zonename INTO @Zone FROM zone WHERE zonecode = v_ZoneCode;
    SELECT divisionname INTO @Division FROM division WHERE divcode = v_DivisionCode;

    SET NEW.Province = @Province;
    SET NEW.District = @District;
    SET NEW.Zone = @Zone;
    SET NEW.Division = @Division;
END

CREATE TRIGGER `before_update_workplace_details_history` BEFORE UPDATE ON `workplace_details_history`
 FOR EACH ROW BEGIN
    DECLARE v_ProCode VARCHAR(3);
    DECLARE v_DistrictCode VARCHAR(3);
    DECLARE v_ZoneCode VARCHAR(6);
    DECLARE v_DivisionCode VARCHAR(6);

    -- Fetch codes from institutions table
    SELECT ProCode, DistrictCode, ZoneCode, DivisionCode
    INTO v_ProCode, v_DistrictCode, v_ZoneCode, v_DivisionCode
    FROM institutions
    WHERE New_CenCode = NEW.selectedInstituteCode;

    -- Fetch names from province, district, zone, and division tables
    SELECT province INTO @Province FROM province WHERE procode = v_ProCode;
    SELECT distname INTO @District FROM district WHERE distcode = v_DistrictCode;
    SELECT zonename INTO @Zone FROM zone WHERE zonecode = v_ZoneCode;
    SELECT divisionname INTO @Division FROM division WHERE divcode = v_DivisionCode;

    SET NEW.Province = @Province;
    SET NEW.District = @District;
    SET NEW.Zone = @Zone;
    SET NEW.Division = @Division;
END


/*
=================================
 Workplace Details Table
 =================================
*/

CREATE TRIGGER `before_insert_workplace_details` BEFORE INSERT ON `workplace_details`
 FOR EACH ROW BEGIN
    DECLARE v_ProCode VARCHAR(3);
    DECLARE v_DistrictCode VARCHAR(3);
    DECLARE v_ZoneCode VARCHAR(6);
    DECLARE v_DivisionCode VARCHAR(6);
    
    -- Fetch codes from institutions table
    SELECT ProCode, DistrictCode, ZoneCode, DivisionCode
    INTO v_ProCode, v_DistrictCode, v_ZoneCode, v_DivisionCode
    FROM institutions
    WHERE New_CenCode = NEW.selectedInstituteCode;
    
    -- Fetch names from province, district, zone, and division tables
    SELECT province INTO @Province FROM province WHERE procode = v_ProCode;
    SELECT distname INTO @District FROM district WHERE distcode = v_DistrictCode;
    SELECT zonename INTO @Zone FROM zone WHERE zonecode = v_ZoneCode;
    SELECT divisionname INTO @Division FROM division WHERE divcode = v_DivisionCode;
    
    SET NEW.Province = @Province;
    SET NEW.District = @District;
    SET NEW.Zone = @Zone;
    SET NEW.Division = @Division;
END

CREATE TRIGGER `before_update_workplace_details` BEFORE UPDATE ON `workplace_details`
 FOR EACH ROW BEGIN
    DECLARE v_ProCode VARCHAR(3);
    DECLARE v_DistrictCode VARCHAR(3);
    DECLARE v_ZoneCode VARCHAR(6);
    DECLARE v_DivisionCode VARCHAR(6);

    -- Fetch codes from institutions table
    SELECT ProCode, DistrictCode, ZoneCode, DivisionCode
    INTO v_ProCode, v_DistrictCode, v_ZoneCode, v_DivisionCode
    FROM institutions
    WHERE New_CenCode = NEW.selectedInstituteCode;

    -- Fetch names from province, district, zone, and division tables
    SELECT province INTO @Province FROM province WHERE procode = v_ProCode;
    SELECT distname INTO @District FROM district WHERE distcode = v_DistrictCode;
    SELECT zonename INTO @Zone FROM zone WHERE zonecode = v_ZoneCode;
    SELECT divisionname INTO @Division FROM division WHERE divcode = v_DivisionCode;

    SET NEW.Province = @Province;
    SET NEW.District = @District;
    SET NEW.Zone = @Zone;
    SET NEW.Division = @Division;
END

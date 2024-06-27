import csv

def escape_sql_string(value):
    """Escapes single quotes in the SQL string."""
    return value.replace("'", "''")

def csv_to_sql_insert(csv_file_path, table_name, output_sql_file):
    insert_statements = []

    drop_table_statement = f"DROP TABLE IF EXISTS `{table_name}`;"
    create_table_statement = (
        f"CREATE TABLE IF NOT EXISTS `{table_name}` ("
        "  `old_zonecode` varchar(6) NOT NULL,"
        "  `old_zonename` varchar(30) DEFAULT '',"
        "  `new_zonecode` varchar(6) NOT NULL,"
        "  `new_zonename` varchar(30) DEFAULT '',"
        "  `distcode` varchar(3) DEFAULT '',"
        "  `zonename_si` varchar(50) DEFAULT '',"
        "  `zonename_ta` varchar(50) DEFAULT '',"
        "  `status` int DEFAULT '0',"
        "  PRIMARY KEY (`old_zonecode`),"
        "  KEY `old_zonecode` (`old_zonecode`),"
        "  KEY `distcode` (`distcode`)"
        ") ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;"
    )
    commit_statement = "COMMIT;"

    with open(csv_file_path, mode='r', encoding='utf-8-sig') as csvfile:
        reader = csv.DictReader(csvfile)
        
        for row in reader:
            old_zonecode = escape_sql_string(row['old_zonecode'])
            old_zonename = escape_sql_string(row['old_zonename'])
            new_zonecode = escape_sql_string(row['new_zonecode'])
            new_zonename = escape_sql_string(row['new_zonename'])
            distcode = escape_sql_string(row['distcode'])
            zonename_si = escape_sql_string(row['zonename_si'])
            zonename_ta = escape_sql_string(row['zonename_ta'])
            status = row['status']

            insert_statement = (
                f"INSERT INTO {table_name} (old_zonecode, old_zonename, new_zonecode, new_zonename, distcode, zonename_si, zonename_ta, status) "
                f"VALUES ('{old_zonecode}', '{old_zonename}', '{new_zonecode}', '{new_zonename}', '{distcode}', '{zonename_si}', '{zonename_ta}', {status});"
            )
            insert_statements.append(insert_statement)
    
    # Write the statements to the SQL file
    with open(output_sql_file, 'w', encoding='utf-8') as sqlfile:
        sqlfile.write(drop_table_statement + '\n')
        sqlfile.write(create_table_statement + '\n')
        for statement in insert_statements:
            sqlfile.write(statement + '\n')
        sqlfile.write(commit_statement + '\n')

# Example usage:
csv_file_path = 'path_to_your_csv_file.csv'
table_name = 'zone'
output_sql_file = 'zone_insert_statements.sql'

csv_to_sql_insert(csv_file_path, table_name, output_sql_file)

print(f"SQL insert statements have been written to {output_sql_file}")

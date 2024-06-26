import csv

def csv_to_sql(csv_file_path, table_name, output_sql_file):
    with open(csv_file_path, mode='r', newline='', encoding='utf-8') as file:
        reader = csv.reader(file)
        columns = next(reader)  # Read the first row for column names
        column_names = ', '.join(columns)
        
        insert_query = f"INSERT INTO {table_name} ({column_names}) VALUES "
        values = []
        
        for row in reader:
            # Enclose each value in quotes and replace empty values with NULL
            row_values = ', '.join(f"'{value}'" if value != '' else 'NULL' for value in row)
            values.append(f"({row_values})")
        
        # Combine all values into the final query
        insert_query += ',\n'.join(values) + ';'
        
        # Write the query to a .sql file
        with open(output_sql_file, 'w', encoding='utf-8') as sql_file:
            sql_file.write(insert_query)
    
    print(f"SQL insert statements saved to {output_sql_file}")

# Usage example
csv_file_path = 'division.csv'
table_name = 'your_table'
output_sql_file = 'division.sql'
csv_to_sql(csv_file_path, table_name, output_sql_file)

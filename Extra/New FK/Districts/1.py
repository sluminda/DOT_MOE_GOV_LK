import csv

# Define the input and output file paths
csv_file_path = 'district_List.csv'
sql_file_path = 'district.sql'

# Define the table name and columns based on the provided SQL table structure
table_name = 'district'
columns = [
    'distcode', 'distname', 'procode', 'distname_si', 'distname_ta', 'status'
]

# Read the CSV file and generate SQL insert queries
with open(csv_file_path, mode='r', encoding='utf-8') as csv_file:
    csv_reader = csv.DictReader(csv_file)
    with open(sql_file_path, mode='w', encoding='utf-8') as sql_file:
        for row in csv_reader:
            # Prepare values for the SQL query, handle missing columns gracefully
            values = [row.get(column, '') for column in columns]
            # Format values as needed (e.g., wrap strings in quotes)
            formatted_values = [
                f"'{value}'" if value != '' else "''"
                for value in values
            ]
            # Generate the SQL insert query
            sql_query = f"INSERT INTO {table_name} ({', '.join(columns)}) VALUES ({', '.join(formatted_values)});"
            # Write the SQL query to the output file
            sql_file.write(sql_query + '\n')

print(f'SQL queries have been written to {sql_file_path}')

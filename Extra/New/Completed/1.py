import openpyxl

def excel_to_sql(excel_file, sql_file):
    # Load the Excel workbook
    wb = openpyxl.load_workbook(excel_file)
    ws = wb.active

    # SQL table name
    table_name = 'institutions'

    # New column names
    columns = [
        'InstType', 'Old_CenCode', 'Old_InstitutionName', 'New_CenCode', 
        'New_InstitutionName', 'ProCode', 'DistrictCode', 'ZoneCode', 
        'DivisionCode', 'IsNationalSchool', 'SchoolType', 'SchoolStatus'
    ]

    # Open the SQL file for writing
    with open(sql_file, 'w', encoding='utf-8') as f:
        for row in ws.iter_rows(min_row=2, values_only=True):
            values = []
            for cell in row:
                if cell is None:
                    values.append('NULL')
                elif isinstance(cell, str):
                    # Escape single quotes by doubling them
                    escaped_value = cell.replace("'", "''")
                    # Encapsulate the value in single quotes to preserve formatting
                    values.append(f"'{escaped_value}'")
                else:
                    values.append(str(cell))

            # Create the INSERT statement
            sql_insert = f"INSERT INTO {table_name} ({', '.join(columns)}) VALUES ({', '.join(values)});"
            f.write(sql_insert + '\n')

# Example usage
excel_file = 'SC, PD, ZN, ED Complete List.xlsx'
sql_file = 'output_sql_file.sql'
excel_to_sql(excel_file, sql_file)

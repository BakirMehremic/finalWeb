<?php

class ExamDao
{

  private $conn;
  private $conn_check;

  /**
   * constructor of dao class
   */
  public function __construct()
  {
    try {
            $this->conn= new PDO(
                            // localhost for windows
                "mysql:host=127.0.0.1;dbname=final;port=3306", "root", "root"
            );
          $this->conn_check = "Connected successfully";
        } catch (PDOException $e) {
            $this->conn_check = "Connection failed: " . $e->getMessage();
        }
  }

  
    public function connection_check()
    {
        return $this->conn_check;
    }

  /** TODO
   * Implement DAO method used to get employees performance report
   */
  public function employees_performance_report() {
      $stmt = $this->conn->prepare("select e.employeeNumber as id, concat(e.firstName, e.lastName) as full_name,
        e.email as email, sum(p.amount) as total
        from employees e 
        join customers c on c.salesRepEmployeeNumber = e.employeeNumber
        join payments p on p.customerNumber = c.customerNumber
        group by e.employeeNumber");
      $stmt->execute();
      //PDO::FETCH_ASSOC removes auto inserted indexes
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /** TODO
   * Implement DAO method used to delete employee by id
   */
  public function delete_employee($employee_id) {
    try {
        $stmt = $this->conn->prepare("DELETE FROM employees WHERE employeeNumber = :employee_id;");
        $stmt->execute(['employee_id' => $employee_id]);

        // will return this message even if employee doesnt exist
        return "Employee deleted.";
    } catch (PDOException $e) {
        return "Error deleting employee: " . $e->getMessage();
    }
  }

  /** TODO
   * Implement DAO method used to edit employee data
   */
public function edit_employee($employee_id, $data) {
    try {
        $first_name = $data["first_name"];
        $last_name = $data["last_name"];
        $email = $data["email"];

        $stmt = $this->conn->prepare("
            UPDATE employees 
            SET firstName = :first_name,
                lastName = :last_name,
                email = :email
            WHERE employeeNumber = :employee_id
        ");
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'employee_id' => $employee_id  
        ]);

        // return the edited employee
        $stmt = $this->conn->prepare("SELECT employeeNumber AS id, firstName AS first_name, lastName AS last_name, email FROM employees WHERE employeeNumber = :employee_id");
        $stmt->execute(['employee_id' => $employee_id]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        return $employee;
    } catch (PDOException $e) {
        return ["message" => "Error updating employee: " . $e->getMessage()];
    }
}


  /** TODO
   * Implement DAO method used to get orders report
   */
  public function get_orders_report() {
    $sql = "
            SELECT 
                o.orderNumber,
                SUM(od.quantityOrdered * od.priceEach) AS totalAmount
            FROM orders o
            JOIN orderdetails od ON o.orderNumber = od.orderNumber
            GROUP BY o.orderNumber
            ORDER BY o.orderNumber
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /** TODO
   * Implement DAO method used to get all products in a single order
   */
  public function get_order_details($order_id) {
    $stmt = $this->conn->prepare("select p.productName as product_name, od.quantityOrdered as quantity,
      od.priceEach as price_each
      from products p 
      join orderdetails od on od.productCode = p.productCode
      where od.orderNumber = :order_id");

    $stmt->execute([
            'order_id' => $order_id  
        ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

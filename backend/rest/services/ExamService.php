<?php
require_once __DIR__."/../dao/ExamDao.php";

class ExamService {
    protected $dao;

    public function __construct(){
        $this->dao = new ExamDao();
    }

    public function connection_check(){
        return $this->dao->connection_check();
    }

    /** TODO
    * Implement service method used to get employees performance report
    */
    public function employees_performance_report(){
        return $this->dao->employees_performance_report();
    }

    /** TODO
    * Implement service method used to delete employee by id
    */
    public function delete_employee($employee_id){
        return $this->dao->delete_employee($employee_id);
    }

    /** TODO
    * Implement service method used to edit employee data
    */
    public function edit_employee($employee_id, $data){
        return $this->dao->edit_employee($employee_id, $data);
    }

    /** TODO
    * Implement service method used to get orders report
    */
    public function get_orders_report(){
    {
        $orders = $this->dao->get_orders_report();

        $result = [];

        foreach ($orders as $order) {
            $orderNumber = $order['orderNumber'];
            $totalAmount = number_format((float)$order['totalAmount'], 2);

            // pojma nemam jel html ok
            $detailsButton = '
                <button
                    type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#order-details-modal"
                    data-bs-id="' . $orderNumber . '">
                    Details
                </button>';

            $result[] = [
                'details' => $detailsButton,
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount
            ];
        }

        return $result;
    }
    }

    /** TODO
    * Implement service method used to get all products in a single order
    */
    public function get_order_details($order_id){
        return $this->dao->get_order_details($order_id);
    }
}
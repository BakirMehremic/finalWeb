var EmployeesService = {
  load_employees: function () {
    console.log("ENTERED LOAD EMPLOYEES FUNCTION");
  RestClient.get("employees/performance", function (data) {
    let tbody = $("#employee-performance tbody");
    tbody.empty();
    data.forEach(function (employee) {
      let row = `
        <tr id="employee-${employee.id}">
          <td class="text-center">
            <div class="btn-group">
              <button class="btn btn-warning" onclick="EmployeesService.edit_employee(${employee.id})">Edit</button>
              <button class="btn btn-danger" onclick="EmployeesService.delete_employee(${employee.id})">Delete</button>
            </div>
          </td>
          <td>${employee.full_name}</td>
          <td>${employee.email}</td>
          <td>${employee.total}</td>
        </tr>`;
      tbody.append(row);
    });
  });
}
,

  delete_employee: function (employee_id) {
    if (confirm("Do you want to delete employee with the id " + employee_id + "?")) {
      RestClient.delete(`employees/${employee_id}`, {}, function () {
        $("#employee-" + employee_id).remove();
        toastr.success("Employee deleted successfully!");
      });
    }
  },


      edit_employee: function(employee_id){
        console.log("Get employee with provided id, open modal and populate modal fields with data returned from the database");
        alert("Opened");
    }
};

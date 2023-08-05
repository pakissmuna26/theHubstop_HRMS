      <div class="accordion" id="accordion">
            <div class="card accordion-item mb-1">
              <h2 class="accordion-header" id="heading">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionAttendanceFilter" aria-expanded="false" aria-controls="accordionAttendanceFilter">
                  Filter
                </button>
              </h2>
              <div id="accordionAttendanceFilter" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionExample">  <div class="accordion-body">
                  <div class="row">
                    <div class="col-lg-4">
                      <label class="form-label">Date From: <span class="validation-area">*</span></label>
                      <input type="date" class="form-control fields" id="txt_date_from">
                    </div>
                    <div class="col-lg-4">
                      <label class="form-label">Date To: <span class="validation-area">*</span></label>
                      <input type="date" class="form-control fields" id="txt_date_to">
                    </div>
                    <div class="col-lg-4">
                      <label class="form-label">Select Type: <span class="validation-area">*</span></label>
                      <select class="form-control fields" id="select_attendance_type_filter">
                        <option value="">All</option>
                        <option value="Daily">Daily Attendance</option>
                        <option value="Overtime">Overtime</option>
                        <option value="Leave Request">Leave Request</option>
                      </select>
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <label class="form-label">Select Personnel: <span class="validation-area">*</span></label>
                      <select class="form-control fields" id="select_personnel"></select>
                    </div>  
                    <div class="col-lg-4">
                      <label class="form-label">Select Attendance Status: <span class="validation-area">*</span></label>
                      <select class="form-control fields" id="select_attendance_status">
                        <option value="">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Denied">Denied</option>
                        <option value="Payroll">Payroll</option>
                      </select>
                    </div>
                    <div class="col-lg-4"><br>
                      <button type="button" id="btnReset" class="btn btn-outline-info" onclick="Reset()" disabled>Reset</button>
                      <button type="button" id="btnGeneratePayroll" class="btn btn-success" onclick="Validate_Data()" disabled>Search</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>              
          </div>
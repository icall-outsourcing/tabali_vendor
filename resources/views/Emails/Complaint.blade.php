<style type="text/css">
  p{
    padding-left:5em;
    
    font-weight: bold;

  }
  table {
    border-collapse: collapse;
    width: 70%;
  }

  
  th 
  {
      text-align: left;
      padding: 8px;
      font-style: italic;
  } 
  td 
  {
      text-align: left;
      padding: 8px;
  }

  tr:nth-child(even){background-color: #f2f2f2}

  th {
      background-color: #244578;
      color: white;
    font-weight: bold;
      text-align: center;
  }
  ul
  {
      list-style-type: none;
      margin-left: -35px;
     
  }
  h4{
    font-style: italic;
  }
</style>
<h4>Dear Gad Team,</h4>
    <p>This to notify you that we have received below complaint from customer side, Kindly check and feed us back</p>
    <p>
      <table border="1">
        <thead>
          <tr>
            <th>Ticket No.</th>
            <th>Priority</th>
            <th>Order Number</th>
            <th>Customer Name</th>
            <th>Phone</th>
            <th>Complaint Type</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody> 
          <tr>
            <td >{{$data->id}}</td>
            <td >{{$data->Priority}}</td>
            <td>{{$data->order_id}}</td>
            <td>{{$data->contact->contact_name}}</td>
            <td>{{$data->contact->follow_up_phone}}</td>
            <td>{{$data->complaint_type}}</td>
            <td>{{$data->complain_comment}}</td>

          </tr>
        </tbody>
      </table>
    </p>
    <p>
      For more details kindly check trouble ticket on below link <br/>
      <a href="{{asset('/Complaint/'.$data->id.'/edit')}}">{{asset('/Complaint/'.$data->id.'/edit')}}</a>
    </p>
<h4><ul>
  <li>Best Regards</li>
  <li>Created at: {{$data->created_at}}</li>
  <li>Created By: {{$data->created_name->name}}</li>
  <li>Icall outsourcing team </li>
</ul></h4>

                 @if(Session::has('flash_notice'))
                    <div class="form-group  alert alert-success">
                                <tr class="danger"><ul>
                                    <h4><td>{{ Session::get('flash_notice') }}</td></h4>
                                     
                                </ul></tr>
                        </div>
                    @elseif(Session::has('flash_error'))
                    <div class="form-group  alert alert-danger">
                                <tr class="danger"><ul>
                                    <h4><td>{{ Session::get('flash_error') }}</td></h4>
                                     
                                </ul></tr>
                        </div>
                    @endif

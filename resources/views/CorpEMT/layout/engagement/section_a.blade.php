<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#1"><i class="fa fa-info"></i> General Information</a>
                    </h4>
                </div>
                <div id="1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form method="post" action="{{ url('corpemt/engagement/savebasicdetails') }}" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-12">Billing Address <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="address" required="required">@if(!empty($info->billing_address)){{$info->billing_address}}@endif</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12">Billing City/State <span class="text-danger">*required</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" name="city" class="form-control" required="required" value="@if(!empty($info->billing_city)){{$info->billing_city}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12">Registered Country <span
                                                    class="text-danger">*required</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" name="country" class="form-control" required="required" value="@if(!empty($info->registered_country)){{$info->registered_country}}@endif">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12">Billing Email <span class="text-danger">*required</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" name="email" class="form-control" required="required" value="@if(!empty($info->billing_email)){{$info->billing_email}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12">Billing Attention <span
                                                    class="text-danger">*required</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" name="attention" class="form-control" required="required"
                                                   value="@if(!empty($info->billing_attention)){{$info->billing_attention}}@endif">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    <input type="hidden" name="client_id" value="{{$client_id}}">
                                    <input type="hidden" name="deal_id" value="{{$deal_id}}">
                                    <input type="hidden" name="company_id" value="{{$company_id}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#2"><i class="fa fa-info"></i> Management</a>
                        <span class="pull-right">
                        <a class="btn btn-xs btn-success" href="#add-management" data-toggle="modal"><i class="fa fa-plus"></i> Add</a>
                      </span>
                    </h4>
                </div>
                <div id="2" class="panel-collapse collapse">
                    <div class="panel-body">
                        @if($management->isEmpty())
                            <p>Yet to add management<p>
                        @else
                            <form method="post" action="{{url('corpemt/engagement/deletemanagement')}}">
                                <input type="hidden" name="client_id" value="{{$client_id}}">
                                <input type="hidden" name="deal_id" value="{{$deal_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <span class="pull-left"><button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete Selected</button></span>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>&nbsp;</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Work Experience</th>
                                        <th>Discussion</th>
                                        <th>Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $sn = 0?>
                                    @foreach($management as $data)
                                        <?php $sn += 1?>
                                        <tr>
                                            <td>{{$sn}}</td>
                                            <td><input type="checkbox" name="check[]" value="{{$data->id}}"></td>
                                            <td>{{$data->title}} {{$data->name}}</td>
                                            <td>{{$data->position}}</td>
                                            <td>{{$data->work_experience}}</td>
                                            <td>{{$data->description}}</td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-primary edit-management"
                                                    data-title="{{$data->title}}" data-fullname="{{$data->name}}"
                                                    data-position="{{$data->position}}"
                                                    data-work="{{$data->work_experience}}"
                                                    data-description="{{$data->description}}"
                                                    data-identity="{{$data->id}}" data-target="#edit-management"
                                                    data-toggle="modal"><i class="fa fa-pencil"></i> Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#2a"><i class="fa fa-info"></i> Audit Committee</a>
                        <span class="pull-right">
                         <a class="btn btn-xs btn-success" href="#add-auditmember" data-toggle="modal"><i class="fa fa-plus"></i> Add</a>
                      </span>
                    </h4>
                </div>
                <div id="2a" class="panel-collapse collapse">
                    <div class="panel-body">
                        @if($committee->isEmpty())
                            <p>Yet to add audit committee<p>
                        @else
                            <form method="post" action="{{url('corpemt/engagement/deletecommittee')}}">
                                <input type="hidden" name="client_id" value="{{$client_id}}">
                                <input type="hidden" name="deal_id" value="{{$deal_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <span class="pull-left"><button type="submit" class="btn btn-xs btn-danger"><i
                                                class="fa fa-trash"></i> Delete Selected</button></span>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>&nbsp;</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $sn = 0?>
                                    @foreach($committee as $data)
                                        <?php $sn += 1?>
                                        <tr>
                                            <td>{{$sn}}</td>
                                            <td><input type="checkbox" name="check[]" value="{{$data->id}}"></td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->position}}</td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-primary edit-committee"
                                                        data-identity="{{$data->id}}" data-poz="{{$data->position}}"
                                                        data-name="{{$data->name}}" data-toggle="modal"
                                                        data-target="#edit-auditmember"><i class="fa fa-pencil"></i>
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#3"><i class="fa fa-info"></i> Industry</a>
                    </h4>
                </div>
                <div id="3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form method="post" action="{{ url('corpemt/engagement/saveindustrydetails') }}" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-12">In what industries does the company operate? <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="operation" required="required">@if(!empty($industry->operation)){{$industry->operation}}@endif</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12">Describe the company’s key products or services, and how the
                                    products or services are used: <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="product_and_services"
                                              required="required">@if(!empty($industry->product_and_services)){{$industry->product_and_services}}@endif</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Describe any special regulatory or reporting requirements that
                                    apply to companies in the industry: <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="requirement" required="required">@if(!empty($industry->regulatory_requirement)){{$industry->regulatory_requirement}}@endif</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                                    <input type="hidden" name="client_id" value="{{$client_id}}">
                                    <input type="hidden" name="deal_id" value="{{$deal_id}}">
                                    <input type="hidden" name="company_id" value="{{$company_id}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#4"><i class="fa fa-info"></i>
                            Financial Highlights</a>
                    </h4>
                </div>
                <div id="4" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form method="post" action="{{ url('corpemt/engagement/savefinancialdetails') }}"
                              class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-12">Describe historical financial information <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="financial_info" required="required">@if(!empty($finance->historical_info)){{$finance->historical_info}}@endif</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Describe risks related to the nature of the company’s major
                                    assets and liabilities:</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12">Assets <span
                                                    class="text-danger">*required</span></label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="assets"
                                                      required="required">@if(!empty($finance->assets)){{$finance->assets}}@endif</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12">Liabilities <span class="text-danger">*required</span></label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="liabilities"
                                                      required="required">@if(!empty($finance->liabilities)){{$finance->liabilities}}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12"> Describe the risks related to the sources of the company’s
                                    revenues and marketing methods: <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="revenue_and_market"
                                              required="required">@if(!empty($finance->revenue_and_market)){{$finance->revenue_and_market}}@endif</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Does the Company face liquidity issues (e.g. going concern
                                    opinion, loan defaults, etc.): <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <?php
                                    if (!empty($finance->liquidity)) {
                                        $yes = $finance->liquidity == 'yes' ? 'checked' : '';
                                        $no = $finance->liquidity == 'no' ? 'checked' : '';
                                    } else {
                                        $no = '';
                                        $yes = '';
                                    }
                                    ?>
                                    <span class="col-xs-2"><input type="checkbox" value="yes" class="liquidity"
                                                                  {{$yes}} data-identity="liquidity"> Yes</span>
                                    <span class="col-xs-2"><input type="checkbox" value="no" class="liquidity"
                                                                  {{$no}} data-identity="liquidity"> No</span>
                                    <input type="hidden" name="liquidity" id="liquidity"
                                           value="@if(!empty($finance->liquidity)){{$finance->liquidity}}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-sm btn-success" name="submit">Save</button>
                                    <input type="hidden" name="client_id" value="{{$client_id}}">
                                    <input type="hidden" name="deal_id" value="{{$deal_id}}">
                                    <input type="hidden" name="company_id" value="{{$company_id}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#5"><i class="fa fa-info"></i> Company
                            Analysis</a>
                    </h4>
                </div>
                <div id="5" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="{{ url('corpemt/engagement/savecompanydetails') }}">
                            <div class="form-group">
                                <label class="col-sm-12">Company Type</label>
                                <div class="col-sm-12">
                                    <span class="col-xs-2"><input type="checkbox" class="company-type" value="private" data-identity="company-type" <?= !empty($company->company) && $company->company == 'private' ? 'checked' : ''?>> Private</span>
                                    <span class="col-xs-2"><input type="checkbox" class="company-type" value="public" data-identity="company-type" <?= !empty($company->company) && $company->company == 'public' ? 'checked' : ''?>> Public</span>
                                    <input type="hidden" name="company_type" id="company-type" value="<?=@$company->company?>">
                                </div>
                            </div>
                            <div class="form-group <?= !empty($company->company) && $company->company == 'private' ? 'hidden' : '' ?> public">
                                <label class="col-sm-12">Is the potential client an SEC issuer as defined? </label>
                                <div class="col-sm-12">
                                    <span class="col-xs-2"><input type="checkbox" class="sec" value="yes"
                                                                  data-identity="sec" <?= !empty($company->potential_client) ? 'checked' : '' ?>> Yes</span>
                                    <span class="col-xs-2"><input type="checkbox" class="sec" value="no"
                                                                  data-identity="sec" <?= empty($company->potential_client) ? 'checked' : '' ?>> No</span>
                                </div>
                            </div>
                            <div class="form-group <?= !empty($company->company) && $company->company == 'private' ? 'hidden' : '' ?> sec-hide">
                                <label class="col-sm-12">Is the potential client one of the following
                                    <small class="text-danger"><i>choose one</i></small>
                                </label>
                                <div class="col-sm-12">
                                    <span class="col-xs-2"><input type="checkbox" class="potential"
                                                                  data-identity="potential"
                                                                  value="small business" <?= !empty($company->potential_client) && $company->potential_client == 'small business' ? 'checked' : '' ?>> a small business (Turnover of less than US$100,000)?</span>
                                    <span class="col-xs-2"><input type="checkbox" class="potential"
                                                                  data-identity="potential"
                                                                  value="sme" <?= !empty($company->potential_client) && $company->potential_client == 'sme' ? 'checked' : '' ?>> an SME?</span>
                                    <span class="col-xs-2"><input type="checkbox" class="potential"
                                                                  data-identity="potential"
                                                                  value="registered in nigeria" <?= !empty($company->potential_client) && $company->potential_client == 'registered in nigeria' ? 'checked' : '' ?>> Registered in Nigeria?</span>
                                    <span class="col-xs-2"><input type="checkbox" class="potential"
                                                                  data-identity="potential"
                                                                  value="private entity" <?= !empty($company->potential_client) && $company->potential_client == 'private entity' ? 'checked' : '' ?>> Private Entity? </span>
                                    <span class="col-xs-2"><input type="checkbox" class="potential"
                                                                  data-identity="potential"
                                                                  value="public entity" <?= !empty($company->potential_client) && $company->potential_client == 'public entity' ? 'checked' : '' ?>> Public Entity?</span>
                                    <span class="col-xs-2"><input type="checkbox" class="potential"
                                                                  data-identity="potential"
                                                                  value="listed company" <?= !empty($company->potential_client) && $company->potential_client == 'listed company' ? 'checked' : '' ?>> a listed company or public interest entity?</span>
                                    <span class="col-xs-2"><input type="checkbox" class="potential"
                                                                  data-identity="potential"
                                                                  value="non-profit" <?= !empty($company->potential_client) && $company->potential_client == 'non-profit' ? 'checked' : '' ?>> a Not-for-Profit, Charity, Grant or Trust?</span>
                                    <input type="hidden" name="potential_client" id="potential"
                                           value="{{@$company->potential_client}}">
                                </div>
                            </div>
                            <div class="form-group <?= !empty($company->company) && $company->company == 'private' ? 'hidden' : '' ?> sec-hide">
                                <label class="col-sm-12">Is the client current on its CAC annual filings?</label>
                                <div class="col-sm-12">
                                    <span class="col-xs-2"><input type="checkbox" value="yes" class="cac"
                                                                  data-identity="cac" <?=@$company->cac == 'yes' ? 'checked' : ''?>> Yes</span>
                                    <span class="col-xs-2"><input type="checkbox" value="no" class="cac"
                                                                  data-identity="cac" <?=@$company->cac == 'no' ? 'checked' : ''?>> No</span>
                                    <input type="hidden" name="cac" id="cac" value="{{@$company->cac}}">
                                </div>
                            </div>
                            <div class="form-group hidden sec-hide">
                                <label class="col-sm-12">What is the client Structure?</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="structure">@if(!empty($company->structure)){{$company->structure}}@endif</textarea>
                                </div>
                            </div>
                            <div class="form-group hidden sec-hide">
                                <label class="col-sm-12">What is the client Share Capital?</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control"
                                              name="share_capital">@if(!empty($company->share_capital)){{$company->share_capital}}@endif</textarea>
                                </div>
                            </div>
                            <div class="form-group <?= !empty($company->company) && $company->company == 'public' ? 'hidden' : '' ?> private">
                                <label class="col-sm-12">Does the company expect to become public within two
                                    years?</label>
                                <div class="col-sm-12">
                                    <span class="col-xs-2"><input type="checkbox" value="yes" class="go-public"
                                                                  data-identity="go-public" <?= !empty($company->go_public) && $company->go_public == 'yes' ? 'checked' : ''?>> Yes</span>
                                    <span class="col-xs-2"><input type="checkbox" value="no" class="go-public"
                                                                  data-identity="go-public" <?= !empty($company->go_public) && $company->go_public == 'no' ? 'checked' : ''?>> No</span>
                                    <input type="hidden" name="go_public" id="go-public" value="{{@$company->go_public}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    <input type="hidden" name="client_id" value="{{$client_id}}">
                                    <input type="hidden" name="deal_id" value="{{$deal_id}}">
                                    <input type="hidden" name="company_id" value="{{$company_id}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
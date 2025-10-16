{if $_tpl == "box"}
  <li class="col-md-6 col-lg-3">
    <div class="ui-box {if $_darker}darker{/if}">
      <div class="img">
        <a href="{$system['system_url']}/schools/{$_school['school_name']}{if $_search}?ref=qs{/if}">
          <img alt="{$_school['school_title']}" src="{$_school['school_picture']}" />
        </a>
      </div>
      <div class="mt10">
        <a class="h6" href="{$system['system_url']}/schools/{$_school['school_name']}{if $_search}?ref=qs{/if}">{$_school['school_title']}</a>
        {if !$_school['monetization_plan']}
          <div>{$_school['school_members']} {__("Members")}</div>
        {/if}
      </div>
      {if $_school['monetization_plan']}
        <div class="mt10">
          <span class="badge bg-info">{print_money($_school['monetization_plan']['price'])} / {if $_school['monetization_plan']['period_num'] != '1'}{$_school['monetization_plan']['period_num']}{/if} {__($_school['monetization_plan']['period']|ucfirst)}</span>
        </div>
      {/if}
      <div class="mt10">
        {if $_connection == 'unsubscribe'}
          {if $user->_data['user_id'] == $_school['plan_user_id']}
            <button type="button" class="btn btn-sm btn-danger js_unsubscribe-plan" data-id="{$_school['plan_id']}">
              <i class="fa fa-trash mr5"></i> {__("Unsubscribe")}
            </button>
          {/if}
        {else}
          {if $_school['i_joined'] == "approved"}
            <button type="button" class="btn btn-sm btn-success {if !$_no_action}btn-delete{/if} js_leave-school" data-id="{$_school['school_id']}" data-privacy="{$_school['school_privacy']}">
              <i class="fa fa-check mr5"></i>{__("Joined")}
            </button>
          {elseif $_school['i_joined'] == "pending"}
            <button type="button" class="btn btn-sm btn-warning js_leave-school" data-id="{$_school['school_id']}" data-privacy="{$_school['school_privacy']}">
              <i class="fa fa-clock mr5"></i>{__("Pending")}
            </button>
          {else}
            <button type="button" class="btn btn-sm btn-success js_join-school" data-id="{$_school['school_id']}" data-privacy="{if $user->_data['user_id'] == $_school['school_admin']}public{else}{$_school['school_privacy']}{/if}">
              <i class="fa fa-user-plus mr5"></i>{__("Join")}
            </button>
          {/if}
        {/if}
      </div>
    </div>
  </li>
{elseif $_tpl == "list"}
  <li class="feeds-item">
    <div class="data-container {if $_small}small{/if}">
      <a class="data-avatar" href="{$system['system_url']}/schools/{$_school['school_name']}{if $_search}?ref=qs{/if}">
        <img src="{$_school['school_picture']}" alt="{$_school['school_title']}">
      </a>
      <div class="data-content">
        <div class="float-end">
          {if $_connection == 'unsubscribe'}
            {if $user->_data['user_id'] == $_school['plan_user_id']}
              <button type="button" class="btn btn-sm btn-danger js_unsubscribe-plan" data-id="{$_school['plan_id']}">
                <i class="fa fa-trash mr5"></i> {__("Unsubscribe")}
              </button>
            {/if}
          {else}
            {if $_school['i_joined'] == "approved"}
              <button type="button" class="btn btn-sm btn-success {if !$_no_action}btn-delete{/if} js_leave-school" data-id="{$_school['school_id']}" data-privacy="{$_school['school_privacy']}">
                <i class="fa fa-check mr5"></i>{__("Joined")}
              </button>
            {elseif $_school['i_joined'] == "pending"}
              <button type="button" class="btn btn-sm btn-warning js_leave-school" data-id="{$_school['school_id']}" data-privacy="{$_school['school_privacy']}">
                <i class="fa fa-clock mr5"></i>{__("Pending")}
              </button>
            {else}
              <button type="button" class="btn btn-sm btn-success js_join-school" data-id="{$_school['school_id']}" data-privacy="{if $user->_data['user_id'] == $_school['school_admin']}public{else}{$_school['school_privacy']}{/if}">
                <i class="fa fa-user-plus mr5"></i>{__("Join")}
              </button>
            {/if}
          {/if}
        </div>
        <div>
          <a class="name" href="{$system['system_url']}/schools/{$_school['school_name']}{if $_search}?ref=qs{/if}">{$_school['school_title']}</a>
          {if !$_school['monetization_plan']}
            <div class="text-muted">{$_school['school_members']} {__("Members")}</div>
          {/if}
        </div>
        {if $_school['monetization_plan']}
          <div class="mt5">
            <span class="badge bg-info">{print_money($_school['monetization_plan']['price'])} / {if $_school['monetization_plan']['period_num'] != '1'}{$_school['monetization_plan']['period_num']}{/if} {__($_school['monetization_plan']['period']|ucfirst)}</span>
          </div>
        {/if}
      </div>
    </div>
  </li>
{else}
  <div class="col-md-6 col-lg-3">
    <div class="ui-box {if $_darker}darker{/if}">
      <div class="img">
        <a href="{$system['system_url']}/schools/{$_school['school_name']}{if $_search}?ref=qs{/if}">
          <img alt="{$_school['school_title']}" src="{$_school['school_picture']}" />
        </a>
      </div>
      <div class="mt10">
        <a class="h6" href="{$system['system_url']}/schools/{$_school['school_name']}{if $_search}?ref=qs{/if}">{$_school['school_title']}</a>
        {if !$_school['monetization_plan']}
          <div>{$_school['school_members']} {__("Members")}</div>
        {/if}
      </div>
      {if $_school['monetization_plan']}
        <div class="mt10">
          <span class="badge bg-info">{print_money($_school['monetization_plan']['price'])} / {if $_school['monetization_plan']['period_num'] != '1'}{$_school['monetization_plan']['period_num']}{/if} {__($_school['monetization_plan']['period']|ucfirst)}</span>
        </div>
      {/if}
      <div class="mt10">
        {if $_connection == 'unsubscribe'}
          {if $user->_data['user_id'] == $_school['plan_user_id']}
            <button type="button" class="btn btn-sm btn-danger js_unsubscribe-plan" data-id="{$_school['plan_id']}">
              <i class="fa fa-trash mr5"></i> {__("Unsubscribe")}
            </button>
          {/if}
        {else}
          {if $_school['i_joined'] == "approved"}
            <button type="button" class="btn btn-sm btn-success {if !$_no_action}btn-delete{/if} js_leave-school" data-id="{$_school['school_id']}" data-privacy="{$_school['school_privacy']}">
              <i class="fa fa-check mr5"></i>{__("Joined")}
            </button>
          {elseif $_school['i_joined'] == "pending"}
            <button type="button" class="btn btn-sm btn-warning js_leave-school" data-id="{$_school['school_id']}" data-privacy="{$_school['school_privacy']}">
              <i class="fa fa-clock mr5"></i>{__("Pending")}
            </button>
          {else}
            <button type="button" class="btn btn-sm btn-success js_join-school" data-id="{$_school['school_id']}" data-privacy="{if $user->_data['user_id'] == $_school['school_admin']}public{else}{$_school['school_privacy']}{/if}">
              <i class="fa fa-user-plus mr5"></i>{__("Join")}
            </button>
          {/if}
        {/if}
      </div>
    </div>
  </div>
{/if}

{* Template hiển thị menu cho pages ẩm thực *}
{if $page_menu && $page_menu_categories}
  <div class="page-menu-section mt30">
    <div class="section-header">
      <h3>
        <i class="fa fa-utensils mr10"></i>
        Thực đơn
      </h3>
      <p class="text-muted">Khám phá các món ngon tại {$spage['page_title']}</p>
    </div>

    <!-- Menu Categories Navigation -->
    <div class="menu-categories-nav mb20">
      <ul class="nav nav-pills justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" href="#all-items" data-bs-toggle="pill">
            <i class="fa fa-th-large mr5"></i>Tất cả
          </a>
        </li>
        {foreach $page_menu_categories as $category}
          <li class="nav-item">
            <a class="nav-link" href="#category-{$category.category_id}" data-bs-toggle="pill">
              <i class="{$category.category_icon} mr5"></i>{$category.category_name}
            </a>
          </li>
        {/foreach}
      </ul>
    </div>

    <!-- Menu Items Content -->
    <div class="tab-content">
      <!-- All Items Tab -->
      <div class="tab-pane fade show active" id="all-items">
        {foreach $page_menu_categories as $category}
          {if $category.items}
            <div class="menu-category-section mb40">
              <h4 class="menu-category-title">
                <i class="{$category.category_icon} mr10"></i>
                {$category.category_name}
              </h4>
              
              <div class="row">
                {foreach $category.items as $item}
                  <div class="col-lg-6 col-xl-4 mb20">
                    <div class="menu-item-card {if !$item.is_available}unavailable{/if}">
                      {if $item.item_image}
                        <div class="menu-item-image">
                          <img src="{$item.item_image}" alt="{$item.item_name}" class="img-fluid">
                          {if $item.is_popular}
                            <span class="popular-badge">
                              <i class="fa fa-fire"></i> Hot
                            </span>
                          {/if}
                          {if !$item.is_available}
                            <div class="unavailable-overlay">
                              <span><i class="fa fa-times-circle"></i> Hết hàng</span>
                            </div>
                          {/if}
                        </div>
                      {/if}
                      
                      <div class="menu-item-content">
                        <h5 class="menu-item-name">
                          {$item.item_name}
                          {if $item.is_popular}
                            <i class="fa fa-fire text-danger ml5" title="Món phổ biến"></i>
                          {/if}
                        </h5>
                        
                        {if $item.item_description}
                          <p class="menu-item-description">{$item.item_description}</p>
                        {/if}
                        
                        <div class="menu-item-footer">
                          <div class="menu-item-price">
                            <strong>{$item.item_price|number_format:0:",":"."} đ</strong>
                          </div>
                          
                          {if $item.is_available}
                            <button class="btn btn-sm btn-primary js_order-item" 
                                    data-item-id="{$item.item_id}" 
                                    data-item-name="{$item.item_name}"
                                    data-item-price="{$item.item_price}">
                              <i class="fa fa-shopping-cart mr5"></i>Đặt món
                            </button>
                          {else}
                            <button class="btn btn-sm btn-secondary" disabled>
                              <i class="fa fa-times mr5"></i>Hết hàng
                            </button>
                          {/if}
                        </div>
                      </div>
                    </div>
                  </div>
                {/foreach}
              </div>
            </div>
          {/if}
        {/foreach}
      </div>

      <!-- Individual Category Tabs -->
      {foreach $page_menu_categories as $category}
        <div class="tab-pane fade" id="category-{$category.category_id}">
          {if $category.items}
            <div class="row">
              {foreach $category.items as $item}
                <div class="col-lg-6 col-xl-4 mb20">
                  <div class="menu-item-card {if !$item.is_available}unavailable{/if}">
                    {if $item.item_image}
                      <div class="menu-item-image">
                        <img src="{$item.item_image}" alt="{$item.item_name}" class="img-fluid">
                        {if $item.is_popular}
                          <span class="popular-badge">
                            <i class="fa fa-fire"></i> Hot
                          </span>
                        {/if}
                      </div>
                    {/if}
                    
                    <div class="menu-item-content">
                      <h5 class="menu-item-name">{$item.item_name}</h5>
                      {if $item.item_description}
                        <p class="menu-item-description">{$item.item_description}</p>
                      {/if}
                      
                      <div class="menu-item-footer">
                        <div class="menu-item-price">
                          <strong>{$item.item_price|number_format:0:",":"."} đ</strong>
                        </div>
                        
                        {if $item.is_available}
                          <button class="btn btn-sm btn-primary js_order-item" 
                                  data-item-id="{$item.item_id}">
                            <i class="fa fa-shopping-cart mr5"></i>Đặt món
                          </button>
                        {else}
                          <button class="btn btn-sm btn-secondary" disabled>
                            Hết hàng
                          </button>
                        {/if}
                      </div>
                    </div>
                  </div>
                </div>
              {/foreach}
            </div>
          {else}
            <div class="text-center py50">
              <i class="fa fa-utensils fa-3x text-muted mb20"></i>
              <h5 class="text-muted">Chưa có món nào trong danh mục này</h5>
            </div>
          {/if}
        </div>
      {/foreach}
    </div>
  </div>

  <!-- Menu CSS -->
  <style>
  .page-menu-section {
    background: #f8f9fa;
    padding: 30px 20px;
    border-radius: 12px;
    margin: 20px 0;
  }
  
  .section-header {
    text-align: center;
    margin-bottom: 30px;
  }
  
  .section-header h3 {
    color: #e74c3c;
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
  }
  
  .menu-categories-nav {
    border-bottom: 1px solid #dee2e6;
    margin-bottom: 30px;
  }
  
  .menu-categories-nav .nav-link {
    color: #6c757d;
    border: none;
    border-radius: 0;
    border-bottom: 3px solid transparent;
    padding: 12px 20px;
    font-weight: 500;
  }
  
  .menu-categories-nav .nav-link.active {
    color: #e74c3c;
    background: none;
    border-bottom-color: #e74c3c;
  }
  
  .menu-item-card {
    background: white;
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
  }
  
  .menu-item-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    transform: translateY(-5px);
  }
  
  .menu-item-card.unavailable {
    opacity: 0.6;
  }
  
  .menu-item-image {
    position: relative;
    height: 220px;
    overflow: hidden;
  }
  
  .menu-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }
  
  .menu-item-card:hover .menu-item-image img {
    transform: scale(1.05);
  }
  
  .popular-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
    box-shadow: 0 2px 8px rgba(255,107,107,0.3);
  }
  
  .unavailable-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 18px;
  }
  
  .menu-item-content {
    padding: 20px;
  }
  
  .menu-item-name {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #2c3e50;
    line-height: 1.3;
  }
  
  .menu-item-description {
    font-size: 14px;
    color: #7f8c8d;
    margin-bottom: 20px;
    line-height: 1.5;
    height: 42px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }
  
  .menu-item-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
  }
  
  .menu-item-price {
    font-size: 20px;
    color: #e74c3c;
    font-weight: bold;
  }
  
  .menu-category-title {
    color: #2c3e50;
    font-size: 24px;
    font-weight: bold;
    border-bottom: 3px solid #e74c3c;
    padding-bottom: 12px;
    margin-bottom: 25px;
    position: relative;
  }
  
  .menu-category-title:after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 60px;
    height: 3px;
    background: #e74c3c;
    border-radius: 2px;
  }
  
  .js_order-item {
    background: linear-gradient(45deg, #e74c3c, #c0392b);
    border: none;
    border-radius: 20px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
  }
  
  .js_order-item:hover {
    background: linear-gradient(45deg, #c0392b, #a93226);
    transform: scale(1.05);
  }
  
  @media (max-width: 768px) {
    .menu-item-image {
      height: 180px;
    }
    
    .menu-item-content {
      padding: 15px;
    }
    
    .menu-item-name {
      font-size: 16px;
    }
    
    .menu-item-price {
      font-size: 18px;
    }
  }
  </style>
{/if}

{hook name="mobilesiteapp-product:one_product" title="{t}Мобильное приложение - список товаров:блок, отображения товаров{/t}"}
{addcss file="mobile_styles.css"}
<ion-card>
    <ion-card-content>
        <ng-template ngFor let-specdir [ngForOf]="product.specdirs">
            <div class="specDirs" tappable (click)="onSelectItem(product)">
                <img *ngIf="specdir.getIcon()" [src]="specdir.getIcon()">
            </div>
        </ng-template>
        <div class="shopItemImg" tappable (click)="onSelectItem(product)">
            <img class="img" [src]="product.getMainImage()['small_url']"/>
        </div>
        {literal}
        <div class="titleWrapper" tappable (click)="onSelectItem(product)">
            <div class="title" [innerHTML]="product.title"></div>
        </div>
            <ng-template [ngIf]="product.isShowMorePrice()">
                <div class="costValuesWrapper" tappable (click)="onSelectItem(product)">
                    <div class="costValues">
                        <div class="costItem">
                            <div class="costTitle">за 1</div>
                            <div class="costOne">{{product?.cost_values.cost_format}}</div>
                        </div>
                        <div class="costItem">
                            <div class="costTitle">от 2-х</div>
                            <div class="costOne">{{product.cost_second_format}}</div>
                        </div>
                        <div class="costItem">
                            <div class="costTitle">от 4-х</div>
                            <div class="costOne">{{product.cost_third_format}}</div>
                        </div>
                    </div>
                    <div class="help">
                        * - при наличии оборотной тары
                    </div>
                </div>
            </ng-template>
            <ng-template [ngIf]="!product.isShowMorePrice()">
                <b class="cost" tappable (click)="onSelectItem(product)">{{product?.cost_values.cost_format}}</b>
            </ng-template>
        {/literal}
        {if $client_version >= 1.2}
        <ion-grid class="productButtonsInList" *ngIf="(product['maindir'] != 4)">
            <ion-row>
                <ion-col col-12 class="first_button">
                    <button block round color="orange" ion-button small tappable (click)="addToCart(product)">В корзину</button>
                </ion-col>
            </ion-row>
            <ion-row>
                <ion-col col-12>
                    <button block round outline color="orange" ion-button small tappable (click)="buyOneClick(product)">Купить в 1 клик</button>
                </ion-col>
            </ion-row>
        </ion-grid>
        {/if}
    </ion-card-content>
</ion-card>
{/hook}
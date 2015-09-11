class CreateProduits < ActiveRecord::Migration
  def change
    create_table :produits do |t|
      t.text :description
      t.decimal :prix
      t.integer :poids

      t.timestamps
    end
  end
end

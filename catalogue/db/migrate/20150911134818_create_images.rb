class CreateImages < ActiveRecord::Migration
  def change
    create_table :images do |t|
      t.string :chemin
      t.references :produit

      t.timestamps
    end
    add_index :images, :produit_id
  end
end

class ProduitsCategories < ActiveRecord::Migration
  def up
    create_table 'produits_categories', :id => false do |t|
      t.column :category_id, :integer
      t.column :produit_id, :integer
    end

    # models/produit.rb
    has_and_belongs_to_many :produits

    # models/category.rb
    has_and_belongs_to_many :categories

  end

  def down
  end
end
